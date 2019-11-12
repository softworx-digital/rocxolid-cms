<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        <iframe style="width: 100%; height: 1000px; padding: 0; margin: 0; border: 1px solid #ccc;" src="{{ $component->getModel()->getPreviewRoute() }}"></iframe>
    </div>

    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back', false) }}</a>
         <div class="btn-group pull-right">
        @if ($component->getModel()->userCan('write'))
            <a href="{{ $component->getModel()->getControllerRoute('show') }}" class="btn btn-success"><i class="fa fa-object-group margin-right-10"></i>{{ $component->translate('button.compose', false) }}</a>
            <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit', false) }}</a>
        @endif
        </div>
    </div>
</div>