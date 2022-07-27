<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Programname')}} </li>


        <!-- attendence-->
        <li>
            <a href="{{route('parent.index')}}"><i class="fas fa-book-open"></i><span
                    class="right-nav-text">تقارير غياب الابناء</span></a>
        </li>


        <!-- exams results-->
        <li>
            <a href="{{route('sons_exams_results')}}"><i class="fas fa-book-open"></i><span
                    class="right-nav-text">تقارير درجات الابناء</span></a>
        </li>

       


        <!-- profile-->
        <li>
            <a href="{{route('parent.create')}}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text">الملف الشخصي</span></a>
        </li>

    </ul>
</div>
