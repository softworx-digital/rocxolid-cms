<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.slider-items') !!}
        <br />
    @if ($component->getModel()->userCan('write'))
        <div class="row">
            <div class="btn-group col-xs-12">
                <a type="button" data-ajax-url="{{ $component->getModel()->getSliderItem()->getControllerRoute('create', [ '_section' => 'main-slider-items', '_data[container_id]' => $component->getModel()->id ]) }}" class="btn btn-info btn-lg margin-right-no col-xs-12"><i class="fa fa-plus margin-right-10"></i>{{ $component->translate('button.add-create-slider-item') }}</a>
            </div>
        </div>
    @endif
    </div>

    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>
    @if ($component->getModel()->userCan('write'))
        <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit') }}</a>
    @endif
    </div>
</div>