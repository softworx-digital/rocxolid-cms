<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.page-elements') !!}
        <br />
    @if ($component->getModel()->userCan('write'))
        <div class="row">
            <div class="btn-group col-xs-12">
                <a type="button" data-ajax-url="{{ $component->getModel()->getControllerRoute('selectPageElementClass', [ 'page_element_class_action' => 'listChoice' ]) }}" class="btn btn-primary btn-lg margin-right-no col-xs-6"><i class="fa fa-list margin-right-10"></i>{{ $component->translate('button.add-existing-element') }}</a>
                <a type="button" data-ajax-url="{{ $component->getModel()->getControllerRoute('selectPageElementClass', [ 'page_element_class_action' => 'create' ]) }}" class="btn btn-primary btn-lg margin-right-no col-xs-6"><i class="fa fa-plus margin-right-10"></i>{{ $component->translate('button.add-create-element') }}</a>
            </div>
        </div>
    @endif
    </div>

    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back', false) }}</a>
         <div class="btn-group pull-right">
        @if (false)
            <a href="{{ $component->getModel()->getControllerRoute('preview') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('preview') }}" class="btn btn-success"><i class="fa fa-binoculars margin-right-10"></i>{{ $component->translate('button.preview', false) }}</a>
        @endif
        @if ($component->getModel()->userCan('write'))
            <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit', false) }}</a>
        @endif
        </div>
    </div>
</div>