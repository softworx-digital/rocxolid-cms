@if ($rxuser ?? false)
<div id="admin-logged">
    <div class="btn-group btn-group-sm" role="group">
    @if ($rxuser->can('update', $rxuser))
        <a href="{{ $rxuser->getControllerRoute('show') }}" target="_blank" class="btn btn-default"><i class="fas fa-user fa-lg"></i> {{ $rxuser->getTitle() }}</a>
    @endif
    @if ($rxuser->can('update', $web))
        <a href="{{ $web->getControllerRoute('show') }}" target="_blank" class="btn btn-default"><i class="fas fa-globe fa-lg"></i> {{ $web->getTitle() }}</a>
    @endif
    @if ($page->exists && $rxuser->can('update', $page))
        <a href="{{ $page->getControllerRoute('show') }}" target="_blank" class="btn btn-default"><i class="fas fa-file fa-lg"></i> {{ $page->getTitle() }}</a>
    @endif
@if (isset($__models))
    @foreach ($__models as $__model)
    @if ($rxuser->can('update', $__model))
        <a href="{{ $__model->getControllerRoute('show') }}" target="_blank" class="btn btn-default"><i class="fas fa-paperclip fa-lg"></i> {{ $__model->getTitle() }}</a>
    @endif
    @endforeach
@endif
    </div>
</div>
@endif