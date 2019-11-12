<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} {{ $component->getModel()->getTitle() }} <small>{{ $component->translate('action.cloneStructure') }}</small></h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-success">
                    <div class="row vertical-align-center">
                        <div class="col-xs-2 text-center"><i class="fa fa-check fa-2x margin-right-10"></i></div>
                        <div class="col-xs-10"><strong>{!! $component->translate('text.clone-structure-success') !!} {{ $shop->getTitle() }}</strong></div>
                    </div>
                </div>
            @if (isset($output))
                <pre>{!! var_export($output) !!}</pre>
            @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close', false) }}</button>
            </div>
        </div>
    </div>
</div>