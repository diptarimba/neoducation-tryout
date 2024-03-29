<div
    class="vertical-menu rtl:right-0 fixed ltr:left-0 bottom-0 top-16 h-screen border-r bg-slate-50 border-gray-50 print:hidden dark:bg-zinc-800 dark:border-neutral-700 z-10">

    <div data-simplebar class="h-full">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                @if (auth()->user()->hasRole('admin'))
                    <x-sidebar.divider title="Menu" />
                    <x-sidebar.first-single title="Dashboard" key="dashboard" icon="home"
                        url="{{ route('admin.dashboard') }}" />
                    <x-sidebar.first-single title="Mata Pelajaran" key="subject" icon="check-circle"
                        url="{{ route('admin.subject.index') }}" />
                    <x-sidebar.first-single title="Mata Ujian" key="subjecttest" icon="clipboard"
                        url="{{ route('admin.test.index') }}" />
                    <x-sidebar.first-single title="Siswa" key="student" icon="users"
                        url="{{ route('admin.user.index') }}" />
                        <x-sidebar.first-single title="Admin" key="admin" icon="command"
                        url="{{ route('admin.admin.index') }}" />
                @elseif (auth()->user()->hasRole('user'))
                    <x-sidebar.divider title="Menu" />
                    <x-sidebar.first-single title="Dashboard" key="dashboard" icon="home"
                        url="{{ route('user.dashboard') }}" />
                    <x-sidebar.first-single title="Enroll Test" key="enrolltest" icon="key"
                        url="{{ route('user.test.enroll.index') }}" />
                    <x-sidebar.first-single title="My Test" key="mytest" icon="menu" url="{{route('user.test.index')}}"/>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
