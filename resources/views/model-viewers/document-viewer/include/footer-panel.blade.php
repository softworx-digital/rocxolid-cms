<div class="x_footer" style="margin-top: 0; border: 0;">
@can ('backAny', $component->getModel())
    <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>
@endcan
@can ('update', $component->getModel())
    <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit') }}</a>
@endcan
</div>