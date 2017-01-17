{{ csrf_field() }}

<div id="document-actions" class="row" data-id="{{ $id }}" data-base-url="{{ $baseUrl }}">
    <div class="col-sm-12 col-md-7">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-default fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Añadir archivos...</span>
        </span>
        <button type="button" class="btn btn-default start">
            <i class="glyphicon glyphicon-upload"></i>
            <span>Empezar subida</span>
        </button>
        <button type="button" class="btn btn-default cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancelar subida</span>
        </button>
    </div>

    <div class="col-sm-12 col-md-5">
        <!-- The global file processing state -->
        <span class="fileupload-process">
          <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
          </div>
        </span>
    </div>
</div>

<div class="table table-striped files" id="document-previews">

    <div class="row">

        <div id="document-template" class="col-sm-12 col-md-6 file-row" style="display: none;">
            <div class="row">
                <!-- This is used as the file preview template -->
                <!-- <div class="col-sm-12 col-md-2">
                    <span class="preview"><img data-dz-thumbnail /></span>
                </div> -->

                <div class="col-sm-12 col-md-4">
                    <p class="name" data-dz-name></p>
                    <strong class="error text-danger" data-dz-errormessage></strong>
                </div>

                <div class="col-sm-12 col-md-4">
                    <p class="size" data-dz-size></p>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width: 0;" data-dz-uploadprogress></div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 btns-container">
                    <button type="button" class="btn btn-default start expand">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Empezar</span>
                    </button>
                    <button type="button" data-dz-remove class="btn btn-default cancel expand">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancelar</span>
                    </button>
                    <a href="" target="_blank" class="btn btn-default download expand">
                        <i class="glyphicon glyphicon-download"></i>
                        <span>Descargar</span>
                    </a>
                    <button type="button" data-dz-remove class="btn btn-default delete expand">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Eliminar</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="clearfix"></div>
