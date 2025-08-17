<x-layouts.base>

    @guest
        {{ $slot }}
    @endguest

    <!-- Layout wrapper -->



    <div class="layout-wrapper layout-content-navbar">

        @auth

        <div class="layout-container">

                @include('components.sidebar')

                <!-- Layout container -->
                <div class="layout-page">

                    <!-- Navbar -->
                    @include('components.navbar')
                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">

                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            {{ $slot }}
                        </div>

                        <!-- Footer -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl">
                                <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                    <div>
                                        11B © <?php echo date('Y'); ?>. All Rights Reserved.
                                    </div>
                                    <div>
                                        Designed & Developed by <a href="https://www.binarycords.com" target="_blank" class="fw-semibold">Binary cords</a>
                                    </div>
                                </div>
                            </div>
                        </footer>

                        <div class="content-backdrop fade"></div>

                    </div>

                </div>

            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>

        @endauth
    </div>
    
    <!-- / Layout wrapper -->
</x-layouts.base>
