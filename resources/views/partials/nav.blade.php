<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">GS Dashboard</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ Request::segment(1) === 'projects' ? 'active' : null }}"><a href="{{ route('projects.index') }}">Projects</a></li>
        <li class="dropdown {{ Request::segment(1) === 'expenses' ? 'active' : null }}">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Expenses <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('expenses.create') }}">New Expense</a></li>
            <li><a href="{{ route('expenses.index') }}">Show Expenses</a></li>
            <li><a href="{{ route('expenses.input') }}">Auto Expenses</a></li>
          </ul>
        </li>
        <li class="{{ Request::segment(1) === 'clients' ? 'active' : null }}"><a href="{{ route('clients.index') }}">Clients</a></li>
        <li class="{{ Request::segment(1) === 'vendors' ? 'active' : null }}"><a href="{{ route('vendors.index') }}">Vendors</a></li>
        <li class="{{ Request::segment(1) === 'checks' ? 'active' : null }}"><a href="{{ route('checks.index') }}">Checks</a></li>
        <li class="dropdown {{ Request::segment(1) === 'hours' ? 'active' : null }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Timesheets <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('hours.create') }}">New Timesheet</a></li>
            <li><a href="{{ route('distributions.index') }}">Distributions</a></li>
          </ul>
        </li>
      </ul>
     {{--  <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form> --}}
  <ul class="nav navbar-nav navbar-right">
      <!-- Authentication Links -->
      @if (Auth::guest())
          <li><a href="{{ route('login') }}">Login</a></li>
          {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
      @else
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  {{ Auth::user()->first_name }} <span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">
                  <li>
                      <a href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Logout
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                  </li>
              </ul>
          </li>
      @endif
  </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>