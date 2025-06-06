<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

 <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   
   <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        header {
            height: 60px;
            background-color: #343a40;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .sidebar {
            width: 220px;
            background-color: #222d32;
            height: calc(100vh - 60px);
            position: fixed;
            top: 60px;
            left: 0;
            transition: width 0.3s;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            color: white;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .sidebar ul li:hover {
            background-color: #1a2226;
        }

        .sidebar ul li i {
            margin-right: 10px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar.collapsed ul li span {
            display: none;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .main-content.expanded {
            margin-left: 60px;
        }

        /* footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px;
            position: sticky;
            bottom: 0;
            margin-top: 131px;
        } */

        .toggle-btn {
            color: white;
            cursor: pointer;
            font-size: 18px;
        }

        .header-right {
    display: flex;
    align-items: center;
}

.user-dropdown {
    position: relative;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.user-name {
    margin-left: 5px;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    min-width: 200px;
    padding: 0;
    margin-top: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 4px;
}

.dropdown-header {
    padding: 8px 16px;
    font-size: 12px;
    color: #6c757d;
}

.dropdown-item {
    padding: 8px 16px;
    display: flex;
    align-items: center;
}

.dropdown-item i {
    margin-right: 8px;
    width: 16px;
    text-align: center;
}

.dropdown-divider {
    margin: 0;
}
        
    
    </style>
</head>
<body>

<header>
    <div class="toggle-btn" id="toggleSidebar"><i class="fas fa-bars"></i></div>
<div>Admin Panel</div>
<div class="header-right">
    <i class="fas fa-bell"></i>
    <div class="user-dropdown" style="margin-left: 10px;">
        <i class="fas fa-user-circle dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
        <span class="user-name">{{ Auth::user()->name }}</span>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-header">
                Logged in as <strong>{{ Auth::user()->role->name }}</strong>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

</header>

<div class="sidebar" id="sidebar">
   <ul>
    <li>
        <a href="{{ route('admin.dashboard') }}" style=" color: #ffffff !important;">
            <i class="fas fa-list"></i> <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('categories.index') }}" style=" color: #ffffff !important;">
            <i class="fas fa-list"></i> <span>Categories</span>
        </a>
    </li>
    <li>
        <a href="{{ route('sub-categories.index') }}" style=" color: #ffffff !important;">
            <i class="fas fa-tags"></i> <span>Sub-Categories</span>
        </a>
    </li>
    <li>
        <a href="{{ route('products.index') }}" style=" color: #ffffff !important;">
            <i class="fas fa-box"></i> <span>Products</span>
        </a>
    </li>
    
    @auth
        @if(auth()->user()->role->slug === 'super-admin')
        <li>
            <a href="{{ route('admin.role-permission') }}" style=" color: #ffffff !important;">
                <i class="fas fa-users-cog"></i> <span>User Management</span>
            </a>
        </li>
        @endif
    @endauth
   </ul>
</div>

<div class="main-content" id="mainContent">
    <!-- <h2>Dashboard</h2>
    <p>Welcome to the admin panel.</p> -->
    <!-- Your blade content goes here -->
    @yield('content')
</div>

<!-- <footer>
    &copy; 2025 Your Company. All rights reserved.
</footer> -->

<script>
    $(document).ready(function() {
    // User dropdown toggle
    $('#userDropdown').click(function(e) {
        e.stopPropagation();
        $(this).siblings('.dropdown-menu').toggle();
    });

    // Close dropdown when clicking outside
    $(document).click(function() {
        $('.dropdown-menu').hide();
    });
});
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });
</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
@yield('scripts')
</body>
</html>
