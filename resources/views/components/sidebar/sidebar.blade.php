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
                    <x-sidebar.first-parent title="Data" icon="users" key="apps" url="/">
                        <x-sidebar.child title="Admin" url="{{ route('admin.admin.index') }}" />
                        <x-sidebar.child title="Mahasiswa" url="{{ route('admin.student.index') }}" />
                        <x-sidebar.child title="Merchant" url="{{ route('admin.merchant.index') }}" />
                        <x-sidebar.child title="App User" url="{{ route('admin.user.app.index') }}" />
                    </x-sidebar.first-parent>
                    <x-sidebar.first-parent title="Tagihan" icon="check-circle" key="apps" url="/">
                        <x-sidebar.child title="Tagihan" url="{{ route('admin.utility.index') }}" />
                        <x-sidebar.child title="Penerima Tagihan" url="{{ route('admin.core.user.index') }}" />
                        <x-sidebar.child title="Kategori Tagihan" url="{{ route('admin.category.index') }}" />
                    </x-sidebar.first-parent>
                    <x-sidebar.first-parent title="Konfigurasi" icon="settings" key="apps"
                        url="{{ route('admin.compensation.index') }}">
                        <x-sidebar.child title="Kompensasi" url="{{ route('admin.compensation.index') }}" />
                    </x-sidebar.first-parent>
                @elseif (auth()->user()->hasRole('merchant'))
                    <x-sidebar.divider title="Menu" />
                    <x-sidebar.first-single title="Dashboard" key="dashboard" icon="home"
                        url="{{ route('merchant.dashboard') }}" />
                    <x-sidebar.first-single title="Transaction" key="dashboard" icon="plus-circle"
                        url="{{ route('merchant.list.index') }}" />
                    <x-sidebar.first-single title="Withdraw" key="dashboard" icon="dollar-sign"
                        url="{{ route('merchant.cashout.index') }}" />
                @else
                    <x-sidebar.divider title="Menu" />
                    <x-sidebar.first-single title="Dashboard" key="dashboard" icon="home"
                        url="{{ route('bank.dashboard') }}" />
                    <x-sidebar.first-single title="Admin" key="bank" icon="users"
                        url="{{ route('bank.admin.index') }}" />
                    <x-sidebar.first-single title="Withdraw" key="bank" icon="log-out"
                        url="{{ route('bank.cashout') }}" />
                    <x-sidebar.first-single title="Deposit" key="bank" icon="log-in"
                        url="{{ route('bank.deposit') }}" />
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
