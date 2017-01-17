<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Province;
use App\Models\Tariff;
use App\Repositories\AddressRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\SupplierCompanyRepository;
use Illuminate\Http\Request;

/**
 * Class SupplierCompaniesController
 * @package App\Http\Controllers
 */
class SupplierCompaniesController extends Controller
{

    /**
     * @var SupplierCompanyRepository
     */
    protected $supplierCompanyRepository;


    /**
     * @var ProvinceRepository
     */
    private $provinceRepository;


    /**
     * @var AddressRepository
     */
    private $addressRepository;


    /**
     * SupplierCompaniesController constructor.
     * @param SupplierCompanyRepository $supplierCompanyRepository
     * @param ProvinceRepository $provinceRepository
     * @param AddressRepository $addressRepository
     */
    public function __construct(
        SupplierCompanyRepository $supplierCompanyRepository,
        ProvinceRepository $provinceRepository,
        AddressRepository $addressRepository) {
        $this->supplierCompanyRepository = $supplierCompanyRepository;
        $this->provinceRepository = $provinceRepository;
        $this->addressRepository = $addressRepository;

        //$this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $supplierCompanies = $this->supplierCompanyRepository->all();

        // Pass to the view
        return view(
            'supplier_companies'
        )->with('supplierCompanies', $supplierCompanies);
    }


    /**
     * Shows the supplier companies creation page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $provinces =  $this->provinceRepository->all();

        return view(
            'supplier_company',
            [
                'provinces' => $provinces
            ]
        );
    }


    /**
     * Shows the supplier companies edition page
     *
     * @param $supplierCompanyId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($supplierCompanyId) {
        $supplierCompany = $this->supplierCompanyRepository->find($supplierCompanyId);

        $provinces = $this->provinceRepository->all();

        return view(
            'supplier_company',
            [
                'supplierCompany' => $supplierCompany,
                'provinces' => $provinces
            ]
        );
    }


    /**
     * Saves or updates supplier company and goes to the listing
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(Request $request) {
        $supplierCompanyId = $request->get('id');


        if ($supplierCompanyId) {
            $supplierCompany = $this->supplierCompanyRepository->find($supplierCompanyId);

            // Update / create address
            if ($request->get('address-locality')) {
                if (! $supplierCompany->getAddress()) {
                    // Create
                    $addressId = $this->addressRepository->create(array(
                        'line' =>  $request->get('address-line'),
                        'postcode' => $request->get('address-post-code'),
                        'province_id' => $request->get('address-province'),
                        'locality' => $request->get('address-locality'),
                        'created_at' => new \DateTime()
                    ));
                } else {
                    // Update
                    $this->addressRepository->update(array(
                        'line' =>  $request->get('address-line'),
                        'postcode' => $request->get('address-post-code'),
                        'province_id' => $request->get('address-province'),
                        'locality' => $request->get('address-locality'),
                        'created_at' => $supplierCompany->getAddress()->created_at
                    ), $supplierCompany->getAddress()->getId());

                    $addressId = $supplierCompany->getAddress()->getId();
                }
            } else {
                $addressId = false;
            }

            // Update supplier company
            $supplierCompanyData = array(
                'name' => $request->get('name'),
                'created_at' => $supplierCompany->created_at
            );

            if ($addressId) {
                $supplierCompanyData['address_id'] = $addressId;
            }

            $this->supplierCompanyRepository->update($supplierCompanyData, $supplierCompanyId);
        } else {
            // Create address
            if ($request->get('address-locality')) {
                $addressId = $this->addressRepository->create(array(
                    'line' =>  $request->get('address-line'),
                    'postcode' => $request->get('address-post-code'),
                    'province_id' => $request->get('address-province'),
                    'locality' => $request->get('address-locality'),
                    'created_at' => new \DateTime()
                ));
            } else {
                $addressId = false;
            }

            // Create
            $supplierCompanyData = array(
                'name' => $request->get('name'),
                'created_at' => new \DateTime()
            );

            if ($addressId) {
                $supplierCompanyData['address_id'] = $addressId;
            }

            $this->supplierCompanyRepository->create($supplierCompanyData);
        }

        return redirect('supplier-companies');
    }


    /**
     * Deletes a supplier company
     *
     * @param $supplierCompanyId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete($supplierCompanyId) {
        $supplierCompany = $this->supplierCompanyRepository->find($supplierCompanyId);

        // Delete his address
        if ($supplierCompany->getAddress()) {
            $this->addressRepository->delete($supplierCompany->getAddress()->getId());
        }

        // Delete contracts

        // Delete the client
        $this->supplierCompanyRepository->delete($supplierCompanyId);

        return redirect('supplier-companies');
    }
}
