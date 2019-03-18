<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ $breadcrumbs->last()->title }}</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                    @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item">{{ $breadcrumb->title }}</li>
                    @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb->title }}</li>
                    @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</div>
