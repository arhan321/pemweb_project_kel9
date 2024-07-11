<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show" style="background-color: #00174d;">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('management_sdm_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/tims*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.managementsdm.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('tim_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.tims.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tims") || request()->is("admin/tims/*") ? "c-active" : "" }}">
                        <i class="fas fa-user-tie c-sidebar-nav-icon"></i>
                           
                        
                        {{ trans('cruds.tim.title') }}
                    </a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
        @can('frontend_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/homes*") ? "c-show" : "" }} {{ request()->is("admin/abouts*") ? "c-show" : "" }} {{ request()->is("admin/whys*") ? "c-show" : "" }} {{ request()->is("admin/blogs*") ? "c-show" : "" }} {{ request()->is("admin/signatures*") ? "c-show" : "" }} {{ request()->is("admin/galleries*") ? "c-show" : "" }} {{ request()->is("admin/testimonials*") ? "c-show" : "" }} {{ request()->is("admin/datachefs*") ? "c-show" : "" }} {{ request()->is("admin/sosial-media*") ? "c-show" : "" }} {{ request()->is("admin/footers*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-globe c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.frontend.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('home_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.homes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/homes") || request()->is("admin/homes/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-home c-sidebar-nav-icon"></i>
                                {{-- <i class="fa-solid fa-house"></i> --}}
                            </i>
                            {{ trans('cruds.home.title') }}
                        </a>
                    </li>
                    @endcan
                    {{-- @can('daftar_layanan_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.daftar-layanans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/daftar-layanans") || request()->is("admin/daftar-layanans/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-concierge-bell c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.daftarLayanan.title') }}
                            </a>
                        </li>
                    @endcan --}}
                    {{-- @can('profile_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.profiles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/profiles") || request()->is("admin/profiles/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-user-circle c-sidebar-nav-icon">
                                    
                                </i>
                                {{ trans('cruds.profile.title') }}
                            </a>
                        </li>
                    @endcan --}}
                    @can('about_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.abouts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/abouts") || request()->is("admin/abouts/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-address-card c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.about.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('why_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.whys.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/whys") || request()->is("admin/whys/*") ? "c-active" : "" }}">
                            <i class="fa-fw far fa-address-card c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.whys.title') }}
                        </a>
                    </li>
                    @endcan
                    {{-- @can('blog_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.blogs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/blogs") || request()->is("admin/blogs/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-newspaper c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.blog.title') }}
                            </a>
                        </li>
                    @endcan --}}
                    @can('signature_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.signatures.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/signatures") || request()->is("admin/signatures/*") ? "c-active" : "" }}">
                            <i class="fa-fw far fa-heart c-sidebar-nav-icon">
                                <i class="fa-solid "></i>
                            </i>
                            {{ trans('cruds.signature.title') }}
                        </a>
                    </li>
                @endcan
                    @can('gallery_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.galleries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/galleries") || request()->is("admin/galleries/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-camera-retro c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.gallery.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('testimonial_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.testimonials.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/testimonials") || request()->is("admin/testimonials/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-star c-sidebar-nav-icon">
                               
                            </i>
                            {{ trans('cruds.testimonial.title') }}
                        </a>
                    </li>
                     @endcan
                    @can('datachef_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.datachefs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/datachefs") || request()->is("admin/datachefs/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-chess-queen c-sidebar-nav-icon">
                                {{-- <i class="fa-regular fa-chess-queen"></i> --}}
                            </i>
                            {{ trans('cruds.datachef.title') }}
                        </a>
                    </li>
                     @endcan
                    {{-- @can('sosial_medium_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sosial-media.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sosial-media") || request()->is("admin/sosial-media/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-share-square c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.sosialMedium.title') }}
                            </a>
                        </li>
                    @endcan --}}
                    @can('footer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.footers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/footers") || request()->is("admin/footers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shoe-prints c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.footer.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('fn_b_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/tables*") ? "c-show" : "" }} {{ request()->is("admin/bookings*") ? "c-show" : "" }} {{ request()->is("admin/booking_manuals*") ? "c-show" : "" }} {{ request()->is("admin/prices*") ? "c-show" : "" }} {{ request()->is("admin/products*") ? "c-show" : "" }} {{ request()->is("admin/orderditempat*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-utensils c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.fnB.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('table_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tables.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tables") || request()->is("admin/tables/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-table c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.table.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('booking_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.bookings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bookings") || request()->is("admin/bookings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.booking.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('bookingmanual_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.booking_manuals.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/booking_manuals") || request()->is("admin/booking_manuals/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.bookingmanual.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('product_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-product-hunt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.product.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('orderditempat_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.orderditempats.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orderditempats") || request()->is("admin/orderditempats/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.orderditempat.title') }}
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
        @endcan
        @can('history_order_access')
        <li class="c-sidebar-nav-dropdown  {{ request()->is("admin/history_order_reservations*") ? "c-show" : "" }} {{ request()->is("admin/history_booking_manuals*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-clock c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.history_order.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('history_order_reservation_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.history_order_reservations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/history_order_reservations") || request()->is("admin/history_order_reservations/*") ? "c-active" : "" }}">
                            <i class="fa-fw far fa-clock c-sidebar-nav-icon">
                             
                            </i>
                            {{ trans('cruds.history_order_reservation.title') }}
                        </a>
                    </li>
                @endcan
                @can('history_booking_manual_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.history_booking_manuals.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/history_booking_manuals") || request()->is("admin/history_booking_manuals/*") ? "c-active" : "" }}">
                        <i class="fa-fw far fa-clock c-sidebar-nav-icon">
                         
                        </i>
                        {{ trans('cruds.history_booking_manual.title') }}
                    </a>
                </li>
            @endcan
            </ul>
        </li>
    @endcan
        
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>