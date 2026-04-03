<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Absensi School</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Absensi
    </div>

    <!-- Scan QR -->
   <li class="nav-item {{ request()->routeIs('scan') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('scan') }}">
        <i class="fas fa-fw fa-qrcode"></i>
        <span>Scan QR Absen</span>
    </a>
</li>


<!-- Scan Mapel -->
<li class="nav-item {{ request()->routeIs('scan.mapel') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('scan.mapel') }}">
        <i class="fas fa-fw fa-chalkboard-teacher"></i>
        <span>Scan Mapel</span>
    </a>
</li>

    <!-- Data Absen -->
    <li class="nav-item">
         <a class="nav-link" href="{{ route('attendance.index') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Data Absensi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Master
    </div>

    <!-- Students -->
    <li class="nav-item">
          <a class="nav-link" href="{{ route('students.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Data Siswa</span></a>
    </li>

   
    <!-- Teachers -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('teachers.index') }}">
        <i class="fas fa-fw fa-user-tie"></i>
        <span>Data Guru</span>
    </a>
</li>


    <!-- Classes -->
    <li class="nav-item">
         <a class="nav-link" href="{{ route('classrooms.index') }}">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Data Kelas</span></a>
    </li>

    <!-- Subjects (Mapel) -->
<li class="nav-item">
   <a class="nav-link" href="{{ route('subjects.index') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>Data Mapel</span>
    </a>
</li>

<!-- Schedules (Jadwal) -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('schedules.index') }}">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span>Data Jadwal</span>
    </a>
</li>

<!-- Rekap Jadwal & Absensi Mapel -->
<li class="nav-item {{ request()->routeIs('attendance.mapel.rekap') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('attendance.mapel.rekap') }}">
        <i class="fas fa-fw fa-chart-bar"></i>
        <span>Rekap Jadwal & Absensi Mapel</span>
    </a>
</li>



    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Rekap & Laporan
    </div>

    <!-- Rekap Bulanan -->
    <li class="nav-item">
        <a class="nav-link" href="rekap.html">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Rekap Absensi</span></a>
    </li>

    <!-- Export -->
    <li class="nav-item">
        <a class="nav-link" href="export.html">
            <i class="fas fa-fw fa-download"></i>
            <span>Export Laporan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
