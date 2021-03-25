<div id="{{ $component->getDomId('modal-destroy-confirm', $component->getModel()->getKey()) }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
    @if ($component->getModel()->isAssignedToProvider(\Softworx\RocXolid\CMS\Models\Document::class))
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }}</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger">
                    <p>{!! $component->translate('text.cannot-destroy-assigned') !!}</p>

                    <ul class="margin-top-5 errors">
                    @foreach ($component->getModel()->getAssignedProviders(\Softworx\RocXolid\CMS\Models\Document::class) as $dependency)
                        <li>{{ $dependency->getModelViewerComponent()->render('snippet.link', [ 'class' => 'alert-link' ]) }}</li>
                    @endforeach
                    </ul>

                    <p class="margin-top-5">{!! $component->translate('text.cannot-destroy-release') !!}</p>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            </div>
    @else
        {{ Form::open([ 'id' => $component->getDomId('destroy-confirmation-form', $component->getModel()->getKey()), 'url' => $component->getController()->getRoute('destroy', $component->getModel()) ]) }}
            {{ Form::hidden('_method', 'DELETE') }}
        @if (request()->has('_data.relation'))
            {{ Form::hidden('_data[relation]', collect(request()->get('_data'))->get('relation')) }}
        @endif
        @if (request()->has('_data.model_attribute'))
            {{ Form::hidden('_data[model_attribute]', collect(request()->get('_data'))->get('model_attribute')) }}
        @endif
        @if (request()->has('_data.model_type'))
            {{ Form::hidden('_data[model_type]', collect(request()->get('_data'))->get('model_type')) }}
        @endif
        @if (request()->has('_data.model_id'))
            {{ Form::hidden('_data[model_id]', collect(request()->get('_data'))->get('model_id')) }}
        @endif
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
                {!! $component->render('include.destroy-confirm-question') !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            @if ($component->getController()->useAjaxDestroyConfirmation())
                <button type="button" class="btn btn-danger pull-right" data-ajax-submit-form="{{ $component->getDomIdHash('destroy-confirmation-form', $component->getModel()->getKey()) }}"><i class="fa fa-trash margin-right-10"></i>{{ $component->translate('button.delete') }}</button>
            @else
                <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash margin-right-10"></i>{{ $component->translate('button.delete') }}</button>
            @endif
            </div>
        {{ Form::close() }}
    @endif
        </div>
    </div>
</div>