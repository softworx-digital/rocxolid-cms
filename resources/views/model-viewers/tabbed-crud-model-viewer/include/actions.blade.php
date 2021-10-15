<div class="btn-group pull-right">
@can ('delete', $component->getModel())
    <a data-dismiss="modal" data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm') }}" class="btn btn-danger"><i class="fa fa-trash margin-right-10"></i>{{ $component->translate('button.delete') }}</a>
@endcan
</div>