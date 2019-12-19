<div id="{{ $component->getDomId('modal-replace-list') }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} {{ $component->getModel()->getTitle() }} <small>{{ $component->translate('action.listContaineeReplace') }}</small></h4>
            </div>
        @if ($component->getModel()->userCan('write'))
            {{ Form::open([ 'id' => $component->getDomId('replace-list'), 'url' => $component->getController()->getRoute('listContaineeReplaceSubmit', $component->getModel()) ]) }}
                {{ Form::hidden('_method', 'PUT') }}
                {{ Form::hidden('_submit-action', 'submit-show') }}

                <div class="modal-body">
                    {!! $component->getFormComponent()->render('include.fieldset') !!}

                    <div class="alert alert-warning">
                        <div class="row vertical-align-center">
                            <div class="col-xs-2 text-center"><i class="fa fa-exclamation-triangle fa-2x margin-right-10"></i></div>
                            <div class="col-xs-10"><strong>{!! $component->translate('text.replace-list-warning') !!}</strong></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
                    <button type="button" class="btn btn-success pull-right" data-ajax-submit-form="{{ $component->getDomIdHash('replace-list') }}"><i class="fa fa-exchange margin-right-10"></i>{{ $component->translate('button.replace') }}</button>
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
        @endif
        </div>
    </div>
</div>