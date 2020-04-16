<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.main-navigation-items') !!}
    @can ('create', [ $component->getModel(), 'items' ])
        <div class="row">
            <div class="btn-group col-xs-12">
                <a
                    type="button"
                    data-ajax-url="{{ $component->getModel()->getNavigationItem()->getControllerRoute('create', [ '_section' => 'main-navigation-items', '_data[container_id]' => $component->getModel()->getKey() ]) }}"
                    class="btn btn-primary btn-lg margin-right-no col-xs-12">
                    <i class="fa fa-plus margin-right-10"></i>
                    {{ $component->translate('button.add-create-navigation-item') }}
                </a>
            </div>
        </div>
    @endcan
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>