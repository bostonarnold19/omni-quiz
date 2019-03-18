@extends('layouts.dashmix')
@section('content')
<div class="bg-dark bg-image" style="background-image: url('{{ asset('themes/dashmix/assets/media/photos/photo23@2x.jpg') }}');">
    <div class="bg-black-75">
        <div class="content content-full content-top">
            <div class="py-4 text-center">
                <h1 class="font-w700 text-white mb-2">
                Omni Aviation
                </h1>
                <h2 class="h3 font-w400 text-white-75">
                Online Questionnaire
                </h2>
                <a class="btn btn-hero-primary" href="javascript:void(0)" data-toggle="click-ripple">
                    <i class="fa fa-play mr-1"></i> Start Exam
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <table class="table table-striped table-borderless table-vcenter">
                <tbody>
                    @for ($i = 1; $i < 11; $i++)
                    <tr>
                        <td class="text-center w-25 d-none d-md-table-cell">
                            <a class="item item-circle bg-primary text-white font-size-h2 mx-auto" href="javascript:void(0)">
                                {{ $i }}
                            </a>
                        </td>
                        <td>
                            <div class="py-4">
                                <div class="font-size-sm font-w700 text-uppercase mb-2">
                                    <span class="text-muted mr-3">Quiz {{ $i }}</span>
                                    <span class="text-primary">
                                        <i class="fa fa-clock"></i> 05:00
                                    </span>
                                </div>
                                <a class="link-fx h4 mb-2 d-inline-block text-dark" href="javascript:void(0)">
                                    Sample Quiz {{ $i }}
                                </a>
                                <p class="text-muted mb-0">
                                    Ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor. Vestibulum ullamcorper, odio sed rhoncus imperdiet, enim elit sollicitudin orci, eget dictum leo mi nec lectus.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
