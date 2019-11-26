<div id="{{ $component->getDomId('modal-clear') }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
        {{ Form::open([ 'id' => $component->getFormComponent()->getDomId('modal-clear'), 'url' => $component->getController()->getRoute('clear', $component->getModel()) ]) }}
            {{ Form::hidden('_method', 'POST') }}
            {{ Form::hidden('_submit-action', null) }}
            {{ Form::hidden('_section', 'page-elements') }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} {{ $component->getModel()->getTitle() }} <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body text-center">
                <big>{{ $component->translate('text.clear-confirmation') }}</big>
                {!! $component->getFormComponent()->render('include.fieldset') !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close', false) }}</button>
                <button type="submit" class="btn btn-success pull-right" data-ajax-submit-form="{{ $component->getFormComponent()->getDomIdHash('modal-clear') }}"><i class="fa fa-check margin-right-10"></i>{{ $component->translate('button.confirm', false) }}</button>
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>