<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate('action.addAdviceExpert') }}</small></h4>
            </div>
            <div class="modal-body padding-top-no padding-bottom-no">
                <div id="{{ $component->makeDomId('output') }}" class="row"></div>
            </div>
    @if ($component->getModel()->adviceExpert()->exists())
            <div class="modal-body text-center">
                <div class="alert alert-warning">
                    <p>{{ $component->translate('text.already-added') }}</p>
                </div>
            </div>

            <div class="modal-footer ">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close', false) }}</button>
            </div>
    @else
        {{ Form::open([ 'url' => $component->getController()->getRoute('addAdviceExpertSubmit', $component->getModel()), 'id' => $component->makeDomId('add-advice-expert') ]) }}
            {{ Form::hidden('_method', 'PUT') }}

        @if (isset($content))
            <div class="modal-body text-center">
                <big>{{ $component->translate('text.add-advice-expert-confirmation') }} <b>{{ $component->getModel()->email }}</b>?</big><br /><br />
                <div class="alert alert-info text-left">
                    <p>{!! $content !!}</p>
                </div>
            </div>
        @else
            <div class="modal-body text-center">
                <div class="alert alert-warning">
                    <p>{{ $component->translate('text.email-notification-note') }}</p>
                </div>
            </div>
        @endif

            <div class="modal-footer ">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close', false) }}</button>
                <div class="btn-group submit-actions pull-right">
                @if (isset($content))
                    {{ Form::hidden('_submit-action', null) }}
                    <button type="button" class="btn btn-success" data-ajax-submit-form="{{ $component->makeDomIdHash('add-advice-expert') }}"><i class="fa fa-check margin-right-10"></i>{{ $component->translate('button.confirm', false) }}</button>
                    <button type="button" class="btn btn-warning" data-submit-action="submit-no-email"><i class="fa fa-check margin-right-10"></i>{{ $component->translate('button.confirm-no-email') }}</button>
                @else
                    {{ Form::hidden('_submit-action', 'submit-no-email') }}
                    <button type="button" class="btn btn-warning" data-ajax-submit-form="{{ $component->makeDomIdHash('add-advice-expert') }}"><i class="fa fa-check margin-right-10"></i>{{ $component->translate('button.confirm-no-email') }}</button>
                @endif
                </div>
            </div>
        {{ Form::close() }}
    @endif
        </div>
    </div>
</div>