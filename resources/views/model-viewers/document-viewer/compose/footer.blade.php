<div class="panel @if ($component->getModel()->hasFooter()) panel-primary @else panel-default @endif">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-5 col-xs-11">
                <h2 class="panel-title with-controls">{{ $component->translate('text.footer') }}</h2>
            </div>
            <div class="col-sm-7 col-xs-1">
                <div class="btn-group btn-group-sm hidden-xs center-block pull-right" role="group">
                @can ('update', $component->getModel())
                    <a class="btn btn-default" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', [ '_section' => 'footer', 'document_id' => $component->getModel() ]) }}" class="margin-left-5 pull-right">
                        <i class="fa fa-cog margin-right-5"></i>
                        {{ $component->translate('button.settings') }}
                    </a>
                @endcan
                @if ($component->getModel()->hasFooter())
                    <button
                        class="btn btn-default collapse-toggle collapsed"
                        data-toggle="collapse"
                        data-target="{{ $component->getDomIdHash('footer') }}"
                        data-parent="{{ $component->getDomIdHash() }}"
                        data-label-hidden="{{ $component->translate('button.collapse-hidden') }}"
                        data-label-shown="{{ $component->translate('button.collapse-shown') }}">
                        <span class="title">{{ $component->translate('button.collapse-hidden') }}</span>
                        <i class="glyphicon glyphicon-chevron-down margin-left-5"></i>
                    </button>
                @endif
                </div>
            </div>
        </div>
    </div>
    <div id="{{ $component->getDomId('footer') }}" class="panel-body panel-collapse collapse padding-0">
    @if ($component->getModel()->hasFooter())
        <div id="{{ $component->getDomId('compose-footer') }}" class="d-none editable-part" data-keditor="html">
            <div
                class="content-composition"
                data-iframe-id="document-footer"
                data-snippets-url="{{ $component->getModel()->getFooter()->getControllerRoute('elementSnippets') }}"
                data-placeholders-url="{{ $component->getModel()->getFooter()->getControllerRoute('contentPlaceholders') }}"
                data-mutators-url="{{ $component->getModel()->getFooter()->getControllerRoute('contentMutators') }}"
                data-update-url="{{ $component->getModel()->getFooter()->getControllerRoute('storeComposition') }}"
                data-element-detach-url="{{ $component->getModel()->getFooter()->getControllerRoute('detachElement') }}"
                data-element-destroy-url="{{ $component->getModel()->getFooter()->getControllerRoute('destroyElement') }}">
                {!! $component->getModel()->getFooter()->getModelViewerComponent()->render('include.elements') !!}
            </div>
        </div>
    @endif
    </div>
</div>