<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.page-elements') !!}
    @can ('assign', [ $component->getModel(), 'pageElements' ])
        <div class="row">
            <div class="btn-group col-xs-12">
                <a
                    type="button"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('selectPageElementClass', [ 'page_element_class_action' => 'listChoice' ]) }}"
                    class="btn btn-primary btn-lg margin-right-no col-xs-6">
                    <i class="fa fa-list margin-right-10"></i>
                    {{ $component->translate('button.add-existing-element') }}
                </a>
                <a
                    type="button"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('selectPageElementClass', [ 'page_element_class_action' => 'create' ]) }}"
                    class="btn btn-primary btn-lg margin-right-no col-xs-6">
                    <i class="fa fa-plus margin-right-10"></i>
                    {{ $component->translate('button.add-create-element') }}
                </a>
            </div>
        </div>
    @endcan
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>