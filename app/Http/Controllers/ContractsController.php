<?php

namespace App\Http\Controllers;

use App\Repositories\AddressRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ContractRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\SupplierCompanyRepository;
use App\Repositories\PowerContractedRepository;

use App\Models\Tariff;

use Illuminate\Http\Request;

/**
 * Class ContractsController
 * @package App\Http\Controllers
 */
class ContractsController extends Controller
{

    /**
     * @var ContractRepository
     */
    protected $contractRepository;


    /**
     * @var ClientRepository
     */
    protected $clientRepository;


    /**
     * @var SupplierCompanyRepository
     */
    protected $supplierCompanyRepository;


    /**
     * @var AddressRepository
     */
    protected $addressRepository;


    /**
     * @var ProvinceRepository
     */
    protected $provinceRepository;

    /**
     * @var PowerContractedRepository
     */
    protected $powerContractedRepository;


    /**
     * ContractsController constructor.
     * @param ContractRepository $contractRepository
     * @param ClientRepository $clientRepository
     * @param SupplierCompanyRepository $supplierCompanyRepository
     * @param AddressRepository $addressRepository
     * @param ProvinceRepository $provinceRepository
     * @param PowerContractedRepository $powerContractedRepository
     */
    public function __construct(
        ContractRepository $contractRepository,
        ClientRepository $clientRepository,
        SupplierCompanyRepository $supplierCompanyRepository,
        AddressRepository $addressRepository,
        ProvinceRepository $provinceRepository,
        PowerContractedRepository $powerContractedRepository) {
        $this->contractRepository = $contractRepository;
        $this->clientRepository = $clientRepository;
        $this->supplierCompanyRepository = $supplierCompanyRepository;
        $this->addressRepository = $addressRepository;
        $this->provinceRepository = $provinceRepository;
        $this->powerContractedRepository = $powerContractedRepository;

        //$this->middleware('auth');
    }


    /**
     * Shows the contract list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $contracts = $this->contractRepository->all();

        return view(
            'contracts'
        )->with('contracts', $contracts);
    }


    /**
     * Returns the contract by id
     * @param $contractId
     *
     * @return array
     */
    public function getById($contractId) {
        $contract = $this->contractRepository->find($contractId);

        return array(
            'contract' => $contract,
            'contract_supply_address' => $contract->getSupplyAddress()
        );
    }


    /**
     * Shows the contract creation page
     * @param $clientId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($clientId = null) {
        $contracts = $this->contractRepository->all();
        $contractTypes = Tariff::toArray();
        $clients = $this->clientRepository->all();
        $supplierCompanies = $this->supplierCompanyRepository->all();
        $provinces = $this->provinceRepository->all();

        if ($clientId) {
            $client = $this->clientRepository->find($clientId);
        } else {
            $client = null;
        }

        return view('contract',
            [
                'contracts' => $contracts,
                'contractTypes' => $contractTypes,
                'clients' => $clients,
                'client' => $client,
                'supplierCompanies' => $supplierCompanies,
                'provinces' => $provinces
            ]);
    }


    /**
     * Shows the contract edition page
     *
     * @param $contractId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($contractId) {
        $contractTypes = Tariff::toArray();
        $contract = $this->contractRepository->find($contractId);
        $clients = $this->clientRepository->all();
        $supplierCompanies = $this->supplierCompanyRepository->all();
        $provinces = $this->provinceRepository->all();

        // Max: 6
        $pwcs = $this->powerContractedRepository->findBy('contract_id', $contractId);

        return view(
            'contract',
            [
                'contract' => $contract,
                'contractTypes' => $contractTypes,
                'clients' => $clients,
                'supplierCompanies' => $supplierCompanies,
                'provinces' => $provinces,
                'pwcs' => $pwcs
            ]
        );
    }


    /**
     * Saves or updates contract and goes to the listing
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request) {
        $contractId = $request->get('id');

        $comissionPaid = ! $request->get('comission-paid') ? false : true;

        if ($contractId) {
            $contract = $this->contractRepository->find($contractId);

            // Update / create address
            if ($request->get('supply-address-line')) {
                if (! $contract->getSupplyAddress()) {
                    // Create
                    $supplyAddressId = $this->addressRepository->create(array(
                        'line' =>  $request->get('supply-address-line'),
                        'postcode' => $request->get('supply-address-post-code'),
                        'province_id' => $request->get('supply-address-province'),
                        'locality' => $request->get('supply-address-locality'),
                        'created_at' => new \DateTime()
                    ));
                } else {
                    // Update
                    $this->addressRepository->update(array(
                        'line' =>  $request->get('supply-address-line'),
                        'postcode' => $request->get('supply-address-post-code'),
                        'province_id' => $request->get('supply-address-province'),
                        'locality' => $request->get('supply-address-locality'),
                        'created_at' => $contract->getSupplyAddress()->created_at
                    ), $contract->getSupplyAddress()->getId());

                    $supplyAddressId = $contract->getSupplyAddress()->getId();
                }
            } else {
                $supplyAddressId = false;
            }

            $contractData = array(
                'date' => new \DateTime($request->get('date')),
                'type' => $request->get('contract-type'),
                'cups' => $request->get('cups'),
                'mean_consuption' => $request->get('mean_consuption'),
                'comission_paid' => $comissionPaid,
                'client_id' => $request->get('client'),
                'supplier_company_id' => $request->get('supplier-company'),
                'created_at' => $contract->created_at
            );

            if ($supplyAddressId) {
                $contractData['supply_address_id'] = $supplyAddressId;
            }

            // Update
            $this->contractRepository->update($contractData, $contractId);

            // Update pwcs
            $pwcs = array();
            foreach (range(0, 5) as $number) {
                $pwc = $request->get('pwc-' . $number);

                array_push($pwcs, $pwc);
            }

            $this->powerContractedRepository->updateByContract($contractId, $pwcs);
        } else {
            // Create address
            if ($request->get('supply-address-line')) {
                $supplyAddressId = $this->addressRepository->create(array(
                    'line' =>  $request->get('supply-address-line'),
                    'postcode' => $request->get('supply-address-post-code'),
                    'province_id' => $request->get('supply-address-province'),
                    'locality' => $request->get('supply-address-locality'),
                    'created_at' => new \DateTime()
                ));
            } else {
                $supplyAddressId = false;
            }

            $contractData = array(
                'date' => new \DateTime($request->get('date')),
                'type' => $request->get('contract-type'),
                'cups' => $request->get('cups'),
                'mean_consuption' => $request->get('mean_consuption'),
                'comission_paid' => $comissionPaid,
                'client_id' => $request->get('client'),
                'supplier_company_id' => $request->get('supplier-company'),
                'created_at' => new \DateTime()
            );

            if ($supplyAddressId) {
                $contractData['supply_address_id'] = $supplyAddressId;
            }

            // Save
            $contractId = $this->contractRepository->create($contractData);


            if ($contractId) {
                // Create pwcs
                foreach (range(0, 5) as $number) {
                    $pwc = $request->get('pwc-' . $number);

                    // Save pwc
                    if ($pwc) {
                        $this->powerContractedRepository->create(array(
                            'total' => $pwc,
                            'contract_id' => $contractId,
                            'created_at' => new \DateTime()
                        ));
                    }
                }
            }

        }

        // Go to edit
        return redirect('contracts/edit/' + $contractId);
    }
}
