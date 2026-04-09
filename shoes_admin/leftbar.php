<!-- Sidebar -->
<aside class="w-64 bg-white/90 backdrop-blur-xl border-r border-gray-200 hidden md:flex flex-col z-20 transition-all duration-300 ease-in-out shadow-sm">
    <div class="h-20 flex items-center justify-center border-b border-gray-100">
        <a href="../shoes_admin/dashboard.php" class="flex items-center gap-2 group">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="transition-transform duration-300 group-hover:scale-110">
                <rect width="40" height="40" rx="12" fill="#c0392b"/>
                <path d="M11 22.5C11 22.5 13 27.5 19 27.5C25 27.5 29 20 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M13 17.5C13 17.5 17 12.5 23 12.5C29 12.5 29 15 29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11 22.5L29 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="font-extrabold text-2xl text-gray-800 tracking-tight group-hover:text-red-600 transition-colors">SoleStyle</span>
        </a>
    </div>
    
    <nav class="flex-1 overflow-y-auto py-6 no-scrollbar">
        <ul class="space-y-2 px-4">
            <li>
                <a href="dashboard.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group hover:shadow-sm hover:translate-x-1">
                    <i class="fas fa-tachometer-alt w-6 text-center mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    <span class="font-semibold">Dashboard</span>
                </a>
            </li>

            <li class="px-4 pt-6 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Inventory</li>
            
            <li>
                <a href="manage-groups.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group hover:shadow-sm hover:translate-x-1">
                    <i class="fas fa-layer-group w-6 text-center mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    <span class="font-medium">Product Groups</span>
                </a>
            </li>

            <li>
                <a href="manage-products.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group hover:shadow-sm hover:translate-x-1">
                    <i class="fas fa-shoe-prints w-6 text-center mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    <span class="font-medium">Products</span>
                </a>
            </li>

            <li class="px-4 pt-6 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Sales</li>
            
            <li>
                <a href="admin_orders.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group hover:shadow-sm hover:translate-x-1">
                    <i class="fas fa-shopping-bag w-6 text-center mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    <span class="font-medium">Orders</span>
                </a>
            </li>

            <li class="px-4 pt-6 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Management</li>
            
            <li>
                <a href="user-account.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group hover:shadow-sm hover:translate-x-1">
                    <i class="fas fa-users w-6 text-center mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    <span class="font-medium">Users List</span>
                </a>
            </li>
            <li>
                <a href="change-password.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group hover:shadow-sm hover:translate-x-1">
                    <i class="fas fa-key w-6 text-center mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    <span class="font-medium">Change Password</span>
                </a>
            </li>
            <li>
                <a href="admin-profile.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group hover:shadow-sm hover:translate-x-1">
                    <i class="fas fa-user-shield w-6 text-center mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                    <span class="font-medium">Admin Profile</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="p-6 border-t border-gray-100">
        <a href="logout.php" class="flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-white bg-gradient-to-r from-red-600 to-red-800 rounded-xl hover:from-red-700 hover:to-red-900 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
    </div>
</aside>