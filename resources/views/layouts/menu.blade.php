 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <img src="{{ URL::asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8;width: 250;">
    <!-- Sidebar -->
    <div class="sidebar">
      

          <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
          
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
              <p>
                Evaluacion
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('escuchadata') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Evaluar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('evalcierre') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cierre Evaluación</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{ route('escuchadata') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Evaluación General</p>
                </a>
              </li> -->
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
              <p>
                Informes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('informes') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Informe Evaluación</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Cargas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('cargas') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Carga de Audios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('cargaAgente') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Carga de Agente</p>
                </a>
              </li>
            </ul>
          </li>        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<script type="text/javascript"></script>