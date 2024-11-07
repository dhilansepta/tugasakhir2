<div class="modal fade" id="@yield('modal-id')" tabindex="-1" aria-labelledby="@yield('modal-label')" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="@yield('modal-label')">@yield('modal-title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @yield('modal-body')
        </div>
    </div>
</div>