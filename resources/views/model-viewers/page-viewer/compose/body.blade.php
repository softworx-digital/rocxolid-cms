<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-5 col-xs-11">
                <h2 class="panel-title with-controls">{{ $component->translate('text.body') }}</h2>
            </div>
            <div class="col-sm-7 col-xs-1">
                <div class="btn-group btn-group-sm hidden-xs center-block pull-right" role="group">
                    <button
                        class="btn btn-default collapse-toggle collapsed"
                        data-toggle="collapse"
                        data-target="{{ $component->getDomIdHash('body') }}"
                        data-parent="{{ $component->getDomIdHash() }}"
                        data-label-hidden="{{ $component->translate('button.collapse-hidden') }}"
                        data-label-shown="{{ $component->translate('button.collapse-shown') }}">
                        <span class="title">{{ $component->translate('button.collapse-hidden') }}</span>
                        <i class="glyphicon glyphicon-chevron-down margin-left-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="{{ $component->getDomId('body') }}" class="panel-body panel-collapse collapse in padding-0">
        <div class="d-none" data-keditor="html">
            <div
                class="content-composition"
                data-iframe-id="document-body"
                data-snippets-url="{{ $component->getModel()->getControllerRoute('elementSnippets') }}"
                data-placeholders-url="{{ $component->getModel()->getControllerRoute('contentPlaceholders') }}"
                data-mutators-url="{{ $component->getModel()->getControllerRoute('contentMutators') }}"
                data-update-url="{{ $component->getModel()->getControllerRoute('storeComposition') }}"
                data-preview-pdf-url="{{ $component->getModel()->getControllerRoute('previewPdf') }}"
                data-element-detach-url="{{ $component->getModel()->getControllerRoute('detachElement') }}"
                data-element-destroy-url="{{ $component->getModel()->getControllerRoute('destroyElement') }}">
                {!! $component->render('include.elements') !!}
            </div>
        </div>
    </div>
</div>