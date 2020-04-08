<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.list-containee') !!}
        <br />
    @can('update', $component->getModel())
        <div class="row">
            <div class="btn-group col-xs-12">
                <a type="button" data-ajax-url="{{ $component->getModel()->getControllerRoute('listContainee') }}" class="btn btn-info btn-lg margin-right-no col-xs-12"><i class="fa fa-list margin-right-10"></i>{{ $component->translate('button.add-select-containee-item') }}</a>
            </div>
        </div>
    @endcan
    </div>

    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>
    @can('update', $component->getModel())
        <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit') }}</a>
    @endcan
    </div>
</div>