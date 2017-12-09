<section class="sidebar" style="height: auto;">

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">Bảng điều khiển</li>
        <li class="active treeview menu-open">
            <a href="#">
                <span>Dashboard</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu" style="">
                <li><a href="{{route('automata_index')}}"> Automata Structure</a></li>
                <li><a href="{{route('term')}}"> Kiểm tra tree automata</a></li>
            </ul>
        </li>
    </ul>
</section>