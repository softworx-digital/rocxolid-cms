<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
    @if ($component->getModel()->isManualContainerFillType())
        {!! $component->render('include.list-containee') !!}
    @endif
        <br />
    @if ($component->getModel()->userCan('write'))
        <div class="row">
            <div class="btn-group col-xs-12">
                <a type="button" data-ajax-url="{{ $component->getModel()->getControllerRoute('listContainee') }}" class="btn btn-primary btn-lg margin-right-no col-xs-6"><i class="fa fa-list margin-right-10"></i>{{ $component->translate('button.add-select-containee-item') }}</a>
            @if ($component->getModel()->productCategory()->exists())
                <a type="button" data-ajax-url="{{ $component->getModel()->getControllerRoute('listContaineeReplace') }}" class="btn btn-primary btn-lg margin-right-no col-xs-6"><i class="fa fa-exchange margin-right-10"></i>{{ $component->translate('button.replace-by-product-category') }}</a>
            @else
                <a type="button" data-ajax-url="{{ $component->getModel()->getControllerRoute('listContaineeReplace') }}" class="btn btn-primary btn-lg margin-right-no col-xs-6"><i class="fa fa-exchange margin-right-10"></i>{{ $component->translate('button.replace-by-all-products') }}</a>
            @endif
            </div>
        </div>
    @endif
    </div>

    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back', false) }}</a>
    @if ($component->getModel()->userCan('write'))
        <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit', false) }}</a>
    @endif
    </div>
</div>