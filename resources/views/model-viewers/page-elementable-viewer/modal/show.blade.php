<div id="{{ $component->getDomId('show', $component->getModel()->id) }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
            @foreach ($component->getModel()->getShowAttributes() as $field => $value)
                <div class="row">
                    <label class="col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $field)) }}</label>
                    <div class="col-xs-6">{{ $component->getModel()->$field }}</div>
                </div>
            @endforeach
            @foreach ($component->getModel()->getRelationshipMethods() as $method)
                <div class="row">
                    <label class="col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $method)) }}</label>
                    <div class="col-xs-6">
                    @foreach ($component->getModel()->$method()->get() as $item)
                        @if ($item->userCan('read-only'))
                            <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
                        @else
                            <span class="label label-info">{{ $item->getTitle() }}</span>
                        @endif
                    @endforeach
                    </div>
                </div>
            @endforeach
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            @if ($component->getModel()->userCan('write'))
                <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit') }}</a>
            @endif
            </div>
        </div>
    </div>
</div>