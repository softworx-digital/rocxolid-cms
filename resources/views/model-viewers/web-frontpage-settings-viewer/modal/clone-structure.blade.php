<div id="{{ $component->getDomId('modal-clone-structure') }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} {{ $component->getModel()->getTitle() }} <small>{{ $component->translate('action.cloneStructure') }}</small></h4>
            </div>
        @can ('create', $component->getModel())
            {{ Form::open([ 'id' => $component->getDomId('clone-structure'), 'url' => $component->getController()->getRoute('cloneStructureSubmit', $component->getModel()) ]) }}
                {{ Form::hidden('_method', 'PUT') }}
                {{ Form::hidden('_submit-action', 'submit-show') }}

                <div class="modal-body">
                    {!! $component->render('include.output') !!}
                    {!! $component->getFormComponent()->render('include.output') !!}
                    {!! $component->getFormComponent()->render('include.fieldset') !!}

                    <div class="alert alert-info">
                        <div class="row vertical-align-center">
                            <div class="col-xs-2 text-center"><i class="fa fa-info-circle fa-2x margin-right-10"></i></div>
                            <div class="col-xs-10"><strong>{!! $component->translate('text.clone-structure-note') !!}</strong></div>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <div class="row vertical-align-center">
                            <div class="col-xs-2 text-center"><i class="fa fa-exclamation-triangle fa-2x margin-right-10"></i></div>
                            <div class="col-xs-10"><strong>{!! $component->translate('text.clone-structure-warning') !!}</strong></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
                    <button type="button" class="btn btn-success pull-right" data-ajax-submit-form="{{ $component->getDomIdHash('clone-structure') }}"><i class="fa fa-clone margin-right-10"></i>{{ $component->translate('button.clone') }}</button>
                </div>
            {{ Form::close() }}
        @else
            <div class="modal-body">
                <p class="text-center"><i class="fa fa-hand-stop-o text-danger fa-5x"></i></p>
                <p class="text-center"><span class="text-big">{{ $component->translate('text.no-access') }}</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            </div>
        @endcan
        </div>
    </div>
</div>