<div class="panel-heading">
    <div class="row">
        <div class="col-sm-5 col-xs-11">
            <h3 class="panel-title">{{ $component->translate('text.header') }}</h3>
        </div>
        <div class="col-sm-7 col-xs-1">
            <div class="btn-group btn-group-sm hidden-xs center-block pull-right" role="group">
            @can ('update', $component->getModel())
                <a class="btn btn-default" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', [ '_section' => 'header', 'document_id' => $component->getModel() ]) }}" class="margin-left-5 pull-right">
                    <i class="fa fa-cog margin-right-5"></i>
                    {{ $component->translate('button.settings') }}
                </a>
            @endcan
            </div>
        </div>
    </div>
</div>
<div class="panel-body padding-0">
@if ($component->getModel()->hasHeader())
    <div class="d-none editable-part" data-keditor="html">
        <div
            class="content-composition"
            data-snippets-url="{{ $component->getModel()->getHeader()->getControllerRoute('elementSnippets') }}"
            data-update-url="{{ $component->getModel()->getHeader()->getControllerRoute('storeComposition') }}"
            data-element-detach-url="{{ $component->getModel()->getHeader()->getControllerRoute('detachElement') }}"
            data-element-destroy-url="{{ $component->getModel()->getHeader()->getControllerRoute('destroyElement') }}">
            {!! $component->getModel()->getHeader()->getModelViewerComponent()->render('include.elements') !!}
        </div>
    </div>
@endif
</div>