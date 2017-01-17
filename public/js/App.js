/**
 * Constants
 */
var DIRECTORY_SEPARATOR = "/";


/**
 * App class
 *
 * @returns {{}}
 * @constructor
 */
var App = function() {
    var app = {};
    $.extend(app, App.methods);

    return app;
};


/**
 * App methods
 * @type {{init: App.methods.init}}
 */
App.methods = {

    /**
     * Updates municipality
     * @param $placeholder
     */
    updateMunicipality: function($placeholder) {
        var provinceId = $placeholder.find('option:selected').val();
        var $municipalities = $placeholder.closest('.address-container').find('.municipality');

        if (! isNaN(provinceId) && provinceId) {
            $municipalities.empty();
            $municipalities.append('<option value="" selected disabled>Seleccionar municipio</option>');

            $.get({
                url: DIRECTORY_SEPARATOR + 'provinces' + DIRECTORY_SEPARATOR + provinceId + DIRECTORY_SEPARATOR + 'municipalities',
                success: function(r) {
                    $.each(r, function(index) {
                        var municipality =  r[index];
                        var initMunicipality = $municipalities.data('init-municipality');

                        var selected = '';
                        if (initMunicipality == municipality.id) {
                            selected = 'selected';
                        }

                        $municipalities.append('<option value="' + municipality.id + '"' + selected + '>' + municipality.name + '</option>');
                    });
                }
            });
        }
    },

    /**
     * Updates contract form based on the contract id
     *
     * @param $placeholder
     * @param contractId
     */
    updateContractData: function($placeholder, contractId) {
        var $cups = $placeholder.find('[name="cups"]');
        var $client = $placeholder.find('[name="client"]');

        // Supply address data
        var $supplyAddressLine = $placeholder.find('[name="supply-address-line"]');
        var $supplyAddressPostCode = $placeholder.find('[name="supply-address-post-code"]');
        var $supplyAddressLocality = $placeholder.find('[name="supply-address-locality"]');
        var $supplyAddressProvince = $placeholder.find('[name="supply-address-province"]');


        if (contractId) {
            // Get contract data from contact id
            $.get({
                url: DIRECTORY_SEPARATOR + 'contracts' + DIRECTORY_SEPARATOR + contractId,
                success: function(r) {
                    var contract = r.contract;
                    var contractSupplyAddress = r.contract_supply_address;

                    if (contract) {

                        // Disable all the inputs for the user
                        // For the select, disable all the options except the correct one
                        $cups.val(contract.cups).prop('readonly', true);
                        $client.find('option').prop('disabled', true);
                        $client.attr('readonly', true)
                            .find('option[value="' + contract.client_id + '"]')
                            .prop('disabled', false)
                            .prop('selected', true);


                        $supplyAddressLine.val(contractSupplyAddress.line).prop('readonly', true);
                        $supplyAddressPostCode.val(contractSupplyAddress.postcode).prop('readonly', true);
                        $supplyAddressLocality.val(contractSupplyAddress.locality).prop('readonly', true);

                        $supplyAddressProvince.find('option').prop('disabled', true);
                        $supplyAddressProvince.attr('readonly', true)
                            .find('option[value="' + contractSupplyAddress.province_id + '"]')
                            .prop('disabled', false)
                            .prop('selected', true);
                    }
                }
            });
        } else {
            // Enable and purge all contract data

            $cups.val('').prop('readonly', false);
            $client.val('')
                .attr('readonly', false)
                .find('option')
                .prop('disabled', false);

            $supplyAddressLine.val('').prop('readonly', false);
            $supplyAddressPostCode.val('').prop('readonly', false);
            $supplyAddressLocality.val('').prop('readonly', false);
            $supplyAddressProvince.val('')
                .attr('readonly', false)
                .find('option')
                .prop('disabled', false);


        }
    },


    /**
     * Add address events
     * @param $placeholder
     */
    addressEvents: function($placeholder) {
        /* $placeholder.find('.province').each(function(index) {
            App.methods.updateMunicipality($(this));

            $(this).change(function() {
                App.methods.updateMunicipality($(this));
            })
        }); */
    },


    /**
     * Add contract events
     * @param $placeholder
     */
    contractEvents: function($placeholder) {
        $placeholder.find('[name="put-contract-data"]').on('click', function() {
            var $selectContract = $placeholder.find('.select-contract');

            // Hide / show the select
            if ($(this).is(':checked')) {
                $selectContract.show();
            } else {
                $selectContract.find('option').eq(0).prop('selected', true);

                $selectContract.hide();

                App.methods.updateContractData($placeholder);
            }
        });


        $placeholder.find('[name="contract-copy"]').unbind().on('change', function() {
           var contractId = $(this).find('option:selected').val();

            App.methods.updateContractData($placeholder, contractId);
        });
    },

    /**
     * Checks for alerts in the system and shows all
     * @param $placeholder
     */
    checkAlerts: function($placeholder) {
        $.get({
            url: DIRECTORY_SEPARATOR + 'alerts' + DIRECTORY_SEPARATOR + 'not-sended',
            success: function(r) {
                var alertMessages = r;

                for (var i = 0; i < alertMessages.length; i++) {
                    var alertMessage = alertMessages[i];

                    $placeholder.append('<div class="message alert alert-danger">' + alertMessage + '</div>')
                }

                // Dissapear after 5 secs
                setTimeout(function() {
                    $placeholder.find('.message').fadeOut();
                }, 5000);
            }
        });
    },


    /**
     * Sets all the code for dropzone
     */
    dropzoneEvents: function($placeholder) {
        if (! $placeholder.find('#document-previews').length
            || ! $placeholder.find("#document-template").length) {
            return;
        }

        var $documentActions = $placeholder.find('#document-actions');
        var id = $documentActions.attr('data-id');
        var baseUrl = $documentActions.attr('data-base-url');

        // Get the template HTML and remove it from the document
        var $previewTemplate = $placeholder.find('#document-template');

        var previewTemplateHtml = $previewTemplate.removeAttr('id').parent().html();

        $previewTemplate.remove();

        // Create dropzone
        var dropzone = new Dropzone($placeholder.get(0), {
            url: baseUrl + DIRECTORY_SEPARATOR + "save" + DIRECTORY_SEPARATOR + id, // Set the url to save
            /*thumbnailWidth: 80,
            thumbnailHeight: 80, */
            parallelUploads: 20,
            previewTemplate: previewTemplateHtml,
            dictRemoveFileConfirmation: '¿Estás seguro de que deseas eliminar el fichero? Esta acción no se puede deshacer.', // Add confirmation text
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#document-previews", // Define the container to display the previews
            clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files
            headers: {
                'X-CSRF-Token': $placeholder.find('input[name="_token"]').val()
            },

            // This has to be here
            init: function() {
                // Check for current files here
                var id = $placeholder.find('[name="id"]').val();

                $.get({
                    url: baseUrl + DIRECTORY_SEPARATOR + id,
                    success: function(r) {
                        var documents = r;

                        for (var i = 0; i < documents.length; i++) {
                            var document = documents[i];

                            // Create the mock file:
                            var mockFile = {
                                name: document.name,
                                size: document.size,
                                isMock: true,
                                documentId:  document.id
                            };

                            // Call the default addedfile event handler
                            dropzone.emit("addedfile", mockFile);

                            // Create thumbnail
                            //dropzone.createThumbnailFromUrl(mockFile, DIRECTORY_SEPARATOR + "documents" + DIRECTORY_SEPARATOR + document.id);

                            // Make sure that there is no progress bar, etc...
                            dropzone.emit("complete", mockFile);
                        }
                    }
                });
            }
        });


        // Dropzone events
        dropzone.on("success", function(file, r) {
            // Add to the file the remove link
            $placeholder.find(file.previewElement).attr('data-document-id', r.documentIds[0]);

            // Set download link
            $placeholder.find(file.previewElement).find('.download').attr('href', DIRECTORY_SEPARATOR + 'documents' + DIRECTORY_SEPARATOR +  r.documentIds[0]);
        });


        dropzone.on("removedfile", function(file) {
            var id =  $(file.previewTemplate).attr('data-document-id');

            if (! id) {
                return;
            }

            // Remove the file
            $.get({
                url: DIRECTORY_SEPARATOR + 'documents' + DIRECTORY_SEPARATOR + 'delete' + DIRECTORY_SEPARATOR + id,
                success: function(r) {
                }
            });
        });

        dropzone.on("addedfile", function(file) {
            var $preview = $(file.previewElement);

            $preview.fadeIn();

            // If is a mock, has been uploaded already
            if (file.isMock) {
                $preview.attr('data-document-id', file.documentId);

                // Change buttons
                $preview.find('.start, .cancel, .progress').hide();
                $preview.find('.download, .delete').show();

                // Fix
                $preview.find('.download').css('display', 'inline-block');

                $preview.find('.download').attr('href', DIRECTORY_SEPARATOR + 'documents' + DIRECTORY_SEPARATOR + file.documentId);
            } else {
                // Check if buttons are showing
                if (! $placeholder.find('#document-actions.start').is(':visible')) {
                    $placeholder.find('#document-actions .start, #document-actions .cancel').fadeIn();
                }

                // Hookup the start button
                $(file.previewElement).find(".start").on('click', function() {
                    dropzone.enqueueFile(file);
                });
            }

        });

        // Update the total progress bar
        dropzone.on("totaluploadprogress", function(progress) {
            $placeholder.find("#total-progress .progress-bar").css('width', progress + "%");
        });

        dropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            $placeholder.find("#total-progress").css('opacity', 1);

            // And disable the start button
            $(file.previewElement).find(".start").attr("disabled", "disabled");
        });

        // Hide the total progress bar when nothing's uploading anymore
        dropzone.on("queuecomplete", function(progress) {
            $placeholder.find("#total-progress").css('opacity', 0);
        });

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        $placeholder.find("#document-actions .start").on('click', function() {
            dropzone.enqueueFiles(dropzone.getFilesWithStatus(Dropzone.ADDED));
        });

        $placeholder.find("#document-actions .cancel").on('click', function() {
            dropzone.removeAllFiles(true);
        });
    },


    /**
     * Initializes the app
     */
    init: function() {
        var $body = $('body');
        var $dataTable = $('#data-table');


        // Datatables
        var dataTableOptions = {
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "zeroRecords": "No se han encontrado resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay resultados",
                "infoFiltered": "(filtrados de _MAX_ resultados totales)",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Búsqueda:",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activar para ordenar por columna ascendiente",
                    "sortDescending": ": activar para ordenar por columna descendiente"
                }
            }
        };


        // Switch order if we are in contracts or alerts
        if ($body.find("#contracts").length || $body.find("#alerts").length) {
            dataTableOptions.order = [[ 0, "desc" ]];

            // Change also the type of ordering for the date (which is first)
            dataTableOptions.columnDefs = [
                { "type": "date-eu", targets: 0 }
            ];
        } else {
            dataTableOptions.order = [[ 0, "asc" ]];
        }

        // Create datatable
        $dataTable.DataTable(dataTableOptions);


        // Vex
        vex.defaultOptions.className = 'vex-theme-plain';
        vex.dialog.buttons.YES.text = 'Aceptar';
        vex.dialog.buttons.NO.text = 'Cancelar';


        // Make row clickable
        $dataTable.find("tr").click(function() {
            var href = $(this).data('href');

            if (typeof href !== 'undefined') {
                window.location = href;
            }
        });


        // Delete action
        $body.find('.delete-action').click(function(e) {
            e.preventDefault();

            var $self = $(this);

            vex.dialog.confirm({
                message: '¿Estás seguro de que deseas realizar esta acción? Esta acción no se puede deshacer.',
                callback: function(confirm) {
                    if (confirm) {
                        $self.closest('form').submit();
                    }
                }
            });

        });


        // Address events
        this.addressEvents($body);

        // Contract events
        this.contractEvents($body);

        // Check alerts
        this.checkAlerts($body.find('.messages'));


        // Dropzone
        Dropzone.autoDiscover = false;

        Dropzone.confirm = function(question, accepted, rejected) {
            vex.dialog.confirm({
                message: question,
                callback: function(confirm) {
                    if (confirm) {
                        // Call accepted
                        accepted();
                    }
                }
            });

            // Call rejected (if defined)
            if (rejected) {
                rejected();
            }
        };


        this.dropzoneEvents($body);
    }
};


/**
 * Jquery methods
 */
$(document).ready(function() {
    var app = new App();

    // CSRF protection for ajax requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        }
    });

    app.init();
});
