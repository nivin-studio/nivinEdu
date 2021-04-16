<!DOCTYPE html>
<html lang="en">

<head>
    <title>拟物校园</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ URL::asset('vendor/index/favicon.ico') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/index/css/tailwind.css') }}">
    <script src="{{ URL::asset('vendor/index/js/jquery.js') }}"></script>
    <script src="{{ URL::asset('vendor/index/js/typed.js') }}"></script>
    <script src="{{ URL::asset('vendor/index/js/main.js') }}"></script>
</head>

<body class="antialiased font-body">
    <div class="absolute h-192 w-full top-0 left-0 bg-brand-gray rounded-b-3xl lg:rounded-b-6xl"></div>

    <!-- 菜单页 -->
    <section class="text-gray-900">
        <!-- PC菜单 -->
        <div class="relative container px-4 mx-auto">
            <nav class="flex justify-between items-center py-6">
                <a class="text-3xl font-semibold leading-none" href="{{ route('home.index') }}">
                    <img class="h-10 rounded-lg" src="{{ URL::asset('vendor/index/images/logo.jpg') }}" alt=""
                        width="auto">
                </a>

                <div class="lg:hidden">
                    <button
                        class="navbar-burger flex items-center py-2 px-3 text-cyan-500 hover:text-cyan-400 rounded border border-cyan-200 hover:border-cyan-300">
                        <svg class="fill-current h-4 w-4" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg>
                    </button>
                </div>

                <ul class="hidden lg:flex lg:items-center lg:w-auto lg:space-x-12">
                    <li><a class="text-base text-blueGray-500 hover:text-cyan-500"
                            href="{{ route('home.index') }}">首页</a></li>
                    <li><a class="text-base text-blueGray-500 hover:text-cyan-500"
                            href="https://github.com/nivin-studio/nivinEdu">Github</a></li>
                    <li><a class="text-base text-blueGray-500 hover:text-cyan-500"
                            href="{{ route('mobile.index') }}">前台</a></li>
                    <li><a class="text-base text-blueGray-500 hover:text-cyan-500"
                            href="{{ route('dcat.admin.login') }}">后台</a></li>
                </ul>

                <div class="hidden lg:block">
                    <a class="mr-2 inline-block px-4 py-3 text-xs text-cyan-500 hover:text-cyan-400 font-semibold leading-none border border-cyan-200 hover:border-cyan-300 rounded"
                        href="{{ route('dcat.admin.login') }}">登录</a>
                    <a class="inline-block px-4 py-3 text-xs font-semibold leading-none bg-cyan-500 hover:bg-cyan-400 text-white rounded"
                        href="{{ route('dcat.admin.register') }}">注册</a>
                </div>
            </nav>
        </div>
        <!-- PC菜单 -->

        <!-- 移动菜单 -->
        <div class="hidden relative navbar-menu z-50">
            <div class="navbar-backdrop fixed inset-0 bg-blueGray-800 opacity-25"></div>
            <nav
                class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
                <div class="flex items-center mb-8">
                    <a class="mr-auto text-3xl font-semibold leading-none" href="{{ route('home.index') }}">
                        <img class="h-10 rounded-lg" src="{{ URL::asset('vendor/index/images/logo.jpg') }}" alt=""
                            width="auto">
                    </a>

                    <button class="navbar-close">
                        <svg class="h-6 w-6 text-blueGray-400 cursor-pointer hover:text-blueGray-500"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div>
                    <ul>
                        <li class="mb-1"><a
                                class="block p-4 text-base text-blueGray-500 hover:bg-cyan-50 hover:text-cyan-600"
                                href="{{ route('home.index') }}">首页</a></li>
                        <li class="mb-1"><a
                                class="block p-4 text-base text-blueGray-500 hover:bg-cyan-50 hover:text-cyan-600"
                                href="https://github.com/nivin-studio/nivinEdu">Github</a></li>
                        <li class="mb-1"><a
                                class="block p-4 text-base text-blueGray-500 hover:bg-cyan-50 hover:text-cyan-600"
                                href="{{ route('mobile.index') }}">前台</a></li>
                        <li class="mb-1"><a
                                class="block p-4 text-base text-blueGray-500 hover:bg-cyan-50 hover:text-cyan-600"
                                href="{{ route('dcat.admin.login') }}">后台</a></li>
                    </ul>

                    <div class="mt-4 pt-6 border-t border-blueGray-100">
                        <a class="block px-4 py-3 mb-3 text-xs text-center font-semibold leading-none bg-cyan-500 hover:bg-cyan-400 text-white rounded"
                            href="{{ route('dcat.admin.register') }}">注册</a>
                        <a class="block px-4 py-3 mb-2 text-xs text-center text-cyan-500 hover:text-cyan-400 font-semibold leading-none border border-cyan-200 hover:border-cyan-300 rounded"
                            href="{{ route('dcat.admin.login') }}">登录</a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- 移动菜单 -->
    </section>
    <!-- 菜单页 -->

    <!-- 主页 -->
    <section class="text-gray-900">
        <!-- 标题口号容器 -->
        <div class="relative container px-4 mx-auto">
            <!-- 左边彩色圆点 -->
            <div class="hidden md:block h-6 w-6 rounded-full bg-red-100 absolute left-0 top-1/4 -mt-16 -ml-24"></div>
            <div class="hidden md:block h-8 w-8 rounded-full bg-cyan-100 absolute left-0 top-1/4 mt-16 ml-16"></div>
            <div class="hidden md:block h-12 w-12 rounded-full bg-yellow-100 absolute left-0 top-1/4 mt-56 -ml-40">
            </div>
            <!-- 左边彩色圆点 -->

            <!-- 左边图标圆点 -->
            <div
                class="hidden md:flex h-12 w-12 rounded-full bg-white shadow items-center justify-center absolute left-0 top-1/4 ml-0 -mt-8">
                <svg class="w-8" viewBox="0 0 128 128">
                    <path fill="#00618A"
                        d="M116.948 97.807c-6.863-.187-12.104.452-16.585 2.341-1.273.537-3.305.552-3.513 2.147.7.733.809 1.829 1.365 2.731 1.07 1.73 2.876 4.052 4.488 5.268 1.762 1.33 3.577 2.751 5.465 3.902 3.358 2.047 7.107 3.217 10.34 5.268 1.906 1.21 3.799 2.733 5.658 4.097.92.675 1.537 1.724 2.732 2.147v-.194c-.628-.8-.79-1.898-1.366-2.733l-2.537-2.537c-2.48-3.292-5.629-6.184-8.976-8.585-2.669-1.916-8.642-4.504-9.755-7.609l-.195-.195c1.892-.214 4.107-.898 5.854-1.367 2.934-.786 5.556-.583 8.585-1.365l4.097-1.171v-.78c-1.531-1.571-2.623-3.651-4.292-5.073-4.37-3.72-9.138-7.437-14.048-10.537-2.724-1.718-6.089-2.835-8.976-4.292-.971-.491-2.677-.746-3.318-1.562-1.517-1.932-2.342-4.382-3.511-6.633-2.449-4.717-4.854-9.868-7.024-14.831-1.48-3.384-2.447-6.72-4.293-9.756-8.86-14.567-18.396-23.358-33.169-32-3.144-1.838-6.929-2.563-10.929-3.513-2.145-.129-4.292-.26-6.438-.391-1.311-.546-2.673-2.149-3.902-2.927-4.894-3.092-17.448-9.817-21.072-.975-2.289 5.581 3.421 11.025 5.462 13.854 1.434 1.982 3.269 4.207 4.293 6.438.674 1.467.79 2.938 1.367 4.489 1.417 3.822 2.652 7.98 4.487 11.511.927 1.788 1.949 3.67 3.122 5.268.718.981 1.951 1.413 2.145 2.927-1.204 1.686-1.273 4.304-1.95 6.44-3.05 9.615-1.899 21.567 2.537 28.683 1.36 2.186 4.567 6.871 8.975 5.073 3.856-1.57 2.995-6.438 4.098-10.732.249-.973.096-1.689.585-2.341v.195l3.513 7.024c2.6 4.187 7.212 8.562 11.122 11.514 2.027 1.531 3.623 4.177 6.244 5.073v-.196h-.195c-.508-.791-1.303-1.119-1.951-1.755-1.527-1.497-3.225-3.358-4.487-5.073-3.556-4.827-6.698-10.11-9.561-15.609-1.368-2.627-2.557-5.523-3.709-8.196-.444-1.03-.438-2.589-1.364-3.122-1.263 1.958-3.122 3.542-4.098 5.854-1.561 3.696-1.762 8.204-2.341 12.878-.342.122-.19.038-.391.194-2.718-.655-3.672-3.452-4.683-5.853-2.554-6.07-3.029-15.842-.781-22.829.582-1.809 3.21-7.501 2.146-9.172-.508-1.666-2.184-2.63-3.121-3.903-1.161-1.574-2.319-3.646-3.124-5.464-2.09-4.731-3.066-10.044-5.267-14.828-1.053-2.287-2.832-4.602-4.293-6.634-1.617-2.253-3.429-3.912-4.683-6.635-.446-.968-1.051-2.518-.391-3.513.21-.671.508-.951 1.171-1.17 1.132-.873 4.284.29 5.462.779 3.129 1.3 5.741 2.538 8.392 4.294 1.271.844 2.559 2.475 4.097 2.927h1.756c2.747.631 5.824.195 8.391.975 4.536 1.378 8.601 3.523 12.292 5.854 11.246 7.102 20.442 17.21 26.732 29.269 1.012 1.942 1.45 3.794 2.341 5.854 1.798 4.153 4.063 8.426 5.852 12.488 1.786 4.052 3.526 8.141 6.05 11.513 1.327 1.772 6.451 2.723 8.781 3.708 1.632.689 4.307 1.409 5.854 2.34 2.953 1.782 5.815 3.903 8.586 5.855 1.383.975 5.64 3.116 5.852 4.879zM29.729 23.466c-1.431-.027-2.443.156-3.513.389v.195h.195c.683 1.402 1.888 2.306 2.731 3.513.65 1.367 1.301 2.732 1.952 4.097l.194-.193c1.209-.853 1.762-2.214 1.755-4.294-.484-.509-.555-1.147-.975-1.755-.556-.811-1.635-1.272-2.339-1.952z">
                    </path>
                </svg>
            </div>
            <div
                class="hidden md:flex h-16 w-16 rounded-full bg-white shadow items-center justify-center absolute left-0 top-1/4 -ml-16 mt-32">
                <svg class="w-10" viewBox="0 0 128 128">
                    <path fill="#FD4F31"
                        d="M14.887 18.316l2.72 4.523 2.507 4.182c1.301 2.17 2.602 4.34 3.901 6.51l2.662 4.44 3.882 6.465 4.749 7.936c1.369 2.285 2.741 4.569 4.112 6.853l.184.267c.199.062.357.009.521-.03 1.807-.434 3.614-.865 5.421-1.296 2.931-.7 5.862-1.398 8.792-2.099l4.592-1.098c2.962-.708 5.926-1.414 8.889-2.124 2.996-.716 5.99-1.436 8.985-2.154 1.514-.363 3.028-.725 4.543-1.086l8.792-2.096 9.575-2.28.517-.14-.141-.28c-.869-1.232-1.742-2.462-2.613-3.693l-2.581-3.654-2.76-3.898-2.639-3.737-2.614-3.693-2.701-3.816-2.646-3.731-1.396-1.969c-.213-.303-.383-.628-.497-.982-.275-.856.039-1.425.538-1.846.324-.274.696-.474 1.1-.593.562-.166 1.128-.324 1.702-.432 1.151-.217 2.309-.402 3.465-.594 1.304-.217 2.609-.424 3.915-.639.825-.136 1.65-.279 2.476-.419l3.367-.567c1.089-.183 2.18-.364 3.269-.543l3.568-.583 2.477-.417c.94-.157 1.882-.314 2.823-.468 1.174-.191 2.346-.384 3.521-.568.698-.109 1.399-.148 2.093.052.521.151.994.395 1.436.706l.61.426c.061-.141-.027-.217-.067-.298-.881-1.782-2.082-3.314-3.606-4.592-1.419-1.187-3.012-2.06-4.773-2.616-1.04-.33-2.109-.483-3.199-.565l-.535-.08h-79.262l-.429.069c-.954.075-1.892.217-2.815.47-2.021.555-3.817 1.519-5.401 2.885-.932.803-1.745 1.707-2.435 2.727-1.065 1.574-1.792 3.285-2.156 5.189l.461.803c1.033 1.726 2.067 3.449 3.101 5.173zM20.128 106.141c.97.373 1.972.635 3.006.762l1.047.047c.163.021.32.05.48.05h32.288c-.052 0-.099-.149-.157-.25-1.271-2.168-2.554-4.296-3.81-6.472-1.581-2.742-3.147-5.477-4.705-8.233-1.664-2.944-3.313-5.89-4.965-8.842-1.569-2.807-3.135-5.611-4.698-8.42-.944-1.698-1.883-3.396-2.825-5.095l-.252-.388-.458.091c-.908.234-1.814.471-2.721.709-1.262.332-2.522.67-3.785 1-2.834.738-5.669 1.471-8.503 2.207-2.883.748-5.704 1.498-8.589 2.243-.175.046.519.062-.481.092v17.905c1 .104.136.294.158.477.066.53.085 1.064.179 1.59.349 1.957 1.089 3.747 2.224 5.378 1.664 2.392 3.852 4.103 6.567 5.149zM14.006 65.751c3.336-.793 6.672-1.585 10.008-2.377l4.396-1.039c.732-.174 1.468-.341 2.194-.537.646-.175.727-.389.394-.973-.481-.844-.97-1.682-1.458-2.522l-4.288-7.383-4.287-7.385c-1.454-2.504-2.909-5.009-4.364-7.513l-3.736-6.427-1.553-2.781c-.1-.17.689-.371-.311-.461v40.135c0-.027.204-.05.333-.081l2.672-.656zM116.677 94.439c-1.308.465-2.615.933-3.923 1.401-2.977 1.067-5.953 2.134-8.93 3.202-1.652.593-3.304 1.193-4.959 1.784-3.371 1.204-6.744 2.403-10.117 3.604-1.955.696-3.91 1.325-5.863 2.024-.535.193-1.063.546-1.593.546h22.431l.484-.046c.569-.024 1.131-.078 1.691-.181 2.303-.421 4.365-1.359 6.191-2.815 1.402-1.118 2.544-2.456 3.438-4.016.92-1.606 1.466-3.329 1.728-5.153.023-.157.072-.328-.06-.491-.184-.014-.349.08-.518.141zM114.75 64.318c-.99-1.353-1.98-2.704-2.968-4.058-1.362-1.869-2.723-3.74-4.083-5.609-.553-.759-1.113-1.512-1.654-2.279-.162-.231-.348-.292-.601-.224l-.145.042c-2.505.608-5.011 1.216-7.517 1.823l-4.489 1.089-8.782 2.133c-2.896.704-5.791 1.408-8.687 2.111-3.01.729-6.02 1.456-9.028 2.186-2.961.719-5.921 1.44-8.881 2.16-2.863.695-5.726 1.391-8.589 2.085-1.513.367-3.025.733-4.537 1.103-.223.054-.463.067-.699.247l.202.385c1.268 2.19 2.535 4.379 3.806 6.567 1.438 2.478 2.878 4.955 4.321 7.43 1.587 2.72 3.178 5.439 4.768 8.159.913 1.562 1.821 3.127 2.742 4.685 1.023 1.73 2.051 3.458 3.094 5.178.312.515.666 1.006 1.023 1.49.24.323.537.599.887.81.36.218.75.286 1.159.194.212-.048.419-.118.624-.189l.754-.279c2.74-.938 5.48-1.875 8.223-2.809 2.139-.729 4.28-1.453 6.421-2.177 2.125-.72 4.251-1.438 6.376-2.155 2.109-.713 4.219-1.425 6.329-2.137 2.157-.729 4.314-1.458 6.471-2.189 2.647-.898 5.294-1.8 7.942-2.696 2.553-.864 5.107-1.723 7.662-2.584.156-.053.329-.075.459-.247l.016-.372c0-5.296-.001-10.594.006-15.891 0-.283-.076-.511-.246-.738-.801-1.077-1.588-2.162-2.379-3.244zM114.311 14.411c-.595-.753-1.352-.992-2.279-.75-.404.106-.819.172-1.23.248-1.351.247-2.701.49-4.052.735-1.976.359-3.951.722-5.928 1.077-1.564.282-3.131.558-4.696.833l-6.281 1.099c-.264.046-.53.092-.783.173-.37.119-.478.351-.309.699.139.284.311.556.497.812 1.298 1.79 2.604 3.576 3.908 5.362 1.798 2.463 3.598 4.926 5.397 7.388 1.522 2.083 3.046 4.166 4.57 6.248 1.197 1.637 2.395 3.272 3.593 4.908l.237.286c3.447-.853 6.889-1.703 10.39-2.568l.024-.538c0-7.208-.001-14.415.006-21.622 0-.318-.078-.574-.277-.826-.875-1.103-1.732-2.219-2.597-3.33l-.19-.234zM117.106 49.333c-1.572.377-3.149.737-4.759 1.163.171.303 4.585 6.262 4.842 6.544l.162.089.018-.363v-2.51c.002-1.455.006-2.911.002-4.366 0-.178.049-.367-.072-.547l-.193-.01zM12.93 127v-17.133h3.633v14.133h6.949v3h-10.582zM36.977 127l-1.242-4.078h-6.246l-1.243 4.078h-3.914l6.047-17.203h4.441l6.071 17.203h-3.914zm-2.11-7.125c-1.148-3.695-1.795-5.785-1.939-6.27s-.248-.867-.311-1.148c-.258 1-.996 3.473-2.215 7.418h4.465zM46.68 120.426v6.574h-3.633v-17.133h4.992c2.328 0 4.051.424 5.168 1.271s1.676 2.135 1.676 3.861c0 1.008-.277 1.904-.832 2.689s-1.34 1.4-2.355 1.846c2.578 3.852 4.258 6.34 5.039 7.465h-4.031l-4.09-6.574h-1.934zm0-2.953h1.172c1.148 0 1.996-.191 2.543-.574s.82-.984.82-1.805c0-.812-.279-1.391-.838-1.734s-1.424-.516-2.596-.516h-1.101v4.629zM69.379 127l-1.242-4.078h-6.246l-1.243 4.078h-3.914l6.047-17.203h4.441l6.071 17.203h-3.914zm-2.109-7.125c-1.148-3.695-1.795-5.785-1.939-6.27s-.248-.867-.311-1.148c-.258 1-.996 3.473-2.215 7.418h4.465zM85.223 109.867h3.668l-5.825 17.133h-3.961l-5.812-17.133h3.668l3.223 10.195c.18.602.365 1.303.557 2.104s.311 1.357.357 1.67c.086-.719.379-1.977.879-3.773l3.246-10.196zM100.914 127h-9.867v-17.133h9.867v2.977h-6.234v3.762h5.801v2.977h-5.801v4.417h6.234v3zM104.488 127v-17.133h3.633v14.133h6.949v3h-10.582z">
                    </path>
                </svg>
            </div>
            <div
                class="hidden md:flex h-12 w-12 rounded-full bg-white shadow items-center justify-center absolute left-0 top-1/4 ml-16 mt-48">
                <svg class="w-8" viewBox="0 0 128 128">
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#439934"
                        d="M88.038 42.812c1.605 4.643 2.761 9.383 3.141 14.296.472 6.095.256 12.147-1.029 18.142-.035.165-.109.32-.164.48-.403.001-.814-.049-1.208.012-3.329.523-6.655 1.065-9.981 1.604-3.438.557-6.881 1.092-10.313 1.687-1.216.21-2.721-.041-3.212 1.641-.014.046-.154.054-.235.08l.166-10.051c-.057-8.084-.113-16.168-.169-24.252l1.602-.275c2.62-.429 5.24-.864 7.862-1.281 3.129-.497 6.261-.98 9.392-1.465 1.381-.215 2.764-.412 4.148-.618z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#45A538"
                        d="M61.729 110.054c-1.69-1.453-3.439-2.842-5.059-4.37-8.717-8.222-15.093-17.899-18.233-29.566-.865-3.211-1.442-6.474-1.627-9.792-.13-2.322-.318-4.665-.154-6.975.437-6.144 1.325-12.229 3.127-18.147l.099-.138c.175.233.427.439.516.702 1.759 5.18 3.505 10.364 5.242 15.551 5.458 16.3 10.909 32.604 16.376 48.9.107.318.384.579.583.866l-.87 2.969z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#46A037"
                        d="M88.038 42.812c-1.384.206-2.768.403-4.149.616-3.131.485-6.263.968-9.392 1.465-2.622.417-5.242.852-7.862 1.281l-1.602.275-.012-1.045c-.053-.859-.144-1.717-.154-2.576-.069-5.478-.112-10.956-.18-16.434-.042-3.429-.105-6.857-.175-10.285-.043-2.13-.089-4.261-.185-6.388-.052-1.143-.236-2.28-.311-3.423-.042-.657.016-1.319.029-1.979.817 1.583 1.616 3.178 2.456 4.749 1.327 2.484 3.441 4.314 5.344 6.311 7.523 7.892 12.864 17.068 16.193 27.433z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#409433"
                        d="M65.036 80.753c.081-.026.222-.034.235-.08.491-1.682 1.996-1.431 3.212-1.641 3.432-.594 6.875-1.13 10.313-1.687 3.326-.539 6.652-1.081 9.981-1.604.394-.062.805-.011 1.208-.012-.622 2.22-1.112 4.488-1.901 6.647-.896 2.449-1.98 4.839-3.131 7.182-1.72 3.503-3.863 6.77-6.353 9.763-1.919 2.308-4.058 4.441-6.202 6.548-1.185 1.165-2.582 2.114-3.882 3.161l-.337-.23-1.214-1.038-1.256-2.753c-.865-3.223-1.319-6.504-1.394-9.838l.023-.561.171-2.426c.057-.828.133-1.655.168-2.485.129-2.982.241-5.964.359-8.946z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#4FAA41"
                        d="M65.036 80.753c-.118 2.982-.23 5.964-.357 8.947-.035.83-.111 1.657-.168 2.485l-.765.289c-1.699-5.002-3.399-9.951-5.062-14.913-2.75-8.209-5.467-16.431-8.213-24.642-2.217-6.628-4.452-13.249-6.7-19.867-.105-.31-.407-.552-.617-.826l4.896-9.002c.168.292.39.565.496.879 2.265 6.703 4.526 13.407 6.768 20.118 2.916 8.73 5.814 17.467 8.728 26.198.116.349.308.671.491 1.062l.67-.78c-.056 3.351-.112 6.701-.167 10.052z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#4AA73C"
                        d="M43.155 32.227c.21.274.511.516.617.826 2.248 6.618 4.483 13.239 6.7 19.867 2.746 8.211 5.463 16.433 8.213 24.642 1.662 4.961 3.362 9.911 5.062 14.913l.765-.289-.171 2.426-.155.559c-.266 2.656-.49 5.318-.814 7.968-.163 1.328-.509 2.632-.772 3.947-.198-.287-.476-.548-.583-.866-5.467-16.297-10.918-32.6-16.376-48.9-1.737-5.187-3.483-10.371-5.242-15.551-.089-.263-.34-.469-.516-.702 1.09-2.947 2.181-5.894 3.272-8.84z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#57AE47"
                        d="M65.202 70.702l-.67.78c-.183-.391-.375-.714-.491-1.062-2.913-8.731-5.812-17.468-8.728-26.198-2.242-6.711-4.503-13.415-6.768-20.118-.105-.314-.327-.588-.496-.879l6.055-7.965c.191.255.463.482.562.769 1.681 4.921 3.347 9.848 5.003 14.778 1.547 4.604 3.071 9.215 4.636 13.813.105.308.47.526.714.786l.012 1.045c.058 8.082.115 16.167.171 24.251z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#60B24F"
                        d="M65.021 45.404c-.244-.26-.609-.478-.714-.786-1.565-4.598-3.089-9.209-4.636-13.813-1.656-4.93-3.322-9.856-5.003-14.778-.099-.287-.371-.514-.562-.769 1.969-1.928 3.877-3.925 5.925-5.764 1.821-1.634 3.285-3.386 3.352-5.968.003-.107.059-.214.145-.514l.519 1.306c-.013.661-.072 1.322-.029 1.979.075 1.143.259 2.28.311 3.423.096 2.127.142 4.258.185 6.388.069 3.428.132 6.856.175 10.285.067 5.478.111 10.956.18 16.434.008.861.098 1.718.152 2.577z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#A9AA88"
                        d="M62.598 107.085c.263-1.315.609-2.62.772-3.947.325-2.649.548-5.312.814-7.968l.066-.01.066.011c.075 3.334.529 6.615 1.394 9.838-.176.232-.425.439-.518.701-.727 2.05-1.412 4.116-2.143 6.166-.1.28-.378.498-.574.744l-.747-2.566.87-2.969z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#B6B598"
                        d="M62.476 112.621c.196-.246.475-.464.574-.744.731-2.05 1.417-4.115 2.143-6.166.093-.262.341-.469.518-.701l1.255 2.754c-.248.352-.59.669-.728 1.061l-2.404 7.059c-.099.283-.437.483-.663.722l-.695-3.985z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#C2C1A7"
                        d="M63.171 116.605c.227-.238.564-.439.663-.722l2.404-7.059c.137-.391.48-.709.728-1.061l1.215 1.037c-.587.58-.913 1.25-.717 2.097l-.369 1.208c-.168.207-.411.387-.494.624-.839 2.403-1.64 4.819-2.485 7.222-.107.305-.404.544-.614.812-.109-1.387-.22-2.771-.331-4.158z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#CECDB7"
                        d="M63.503 120.763c.209-.269.506-.508.614-.812.845-2.402 1.646-4.818 2.485-7.222.083-.236.325-.417.494-.624l-.509 5.545c-.136.157-.333.294-.398.477-.575 1.614-1.117 3.24-1.694 4.854-.119.333-.347.627-.525.938-.158-.207-.441-.407-.454-.623-.051-.841-.016-1.688-.013-2.533z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#DBDAC7"
                        d="M63.969 123.919c.178-.312.406-.606.525-.938.578-1.613 1.119-3.239 1.694-4.854.065-.183.263-.319.398-.477l.012 3.64-1.218 3.124-1.411-.495z">
                    </path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#EBE9DC"
                        d="M65.38 124.415l1.218-3.124.251 3.696-1.469-.572z"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#CECDB7"
                        d="M67.464 110.898c-.196-.847.129-1.518.717-2.097l.337.23-1.054 1.867z"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#4FAA41"
                        d="M64.316 95.172l-.066-.011-.066.01.155-.559-.023.56z"></path>
                </svg>
            </div>
            <!-- 左边图标圆点 -->

            <!-- 右边彩色圆点 -->
            <div class="hidden md:block h-6 w-6 rounded-full bg-yellow-50 absolute right-0 top-1/4 -mt-16 -mr-24"></div>
            <div class="hidden md:block h-8 w-8 rounded-full bg-indigo-100 absolute right-0 top-1/4 mt-16 mr-16"></div>
            <div class="hidden md:block h-12 w-12 rounded-full bg-red-100 absolute right-0 top-1/4 mt-56 -mr-40"></div>
            <!-- 右边彩色圆点 -->

            <!-- 右边图标圆点 -->
            <div
                class="hidden md:flex h-12 w-12 rounded-full bg-white shadow items-center justify-center absolute right-0 top-1/4 mr-0 -mt-8">
                <svg class="w-8" viewBox="0 0 128 128">
                    <g>
                        <path fill="#A41E11"
                            d="M121.8 93.1c-6.7 3.5-41.4 17.7-48.8 21.6-7.4 3.9-11.5 3.8-17.3 1s-42.7-17.6-49.4-20.8c-3.3-1.6-5-2.9-5-4.2v-12.7s48-10.5 55.8-13.2c7.8-2.8 10.4-2.9 17-.5s46.1 9.5 52.6 11.9v12.5c0 1.3-1.5 2.7-4.9 4.4z">
                        </path>
                        <path fill="#D82C20"
                            d="M121.8 80.5c-6.7 3.5-41.4 17.7-48.8 21.6-7.4 3.9-11.5 3.8-17.3 1-5.8-2.8-42.7-17.7-49.4-20.9-6.6-3.2-6.8-5.4-.3-7.9 6.5-2.6 43.2-17 51-19.7 7.8-2.8 10.4-2.9 17-.5s41.1 16.1 47.6 18.5c6.7 2.4 6.9 4.4.2 7.9z">
                        </path>
                        <path fill="#A41E11"
                            d="M121.8 72.5c-6.7 3.5-41.4 17.7-48.8 21.6-7.4 3.8-11.5 3.8-17.3 1-5.8-2.8-42.7-17.7-49.4-20.9-3.3-1.6-5-2.9-5-4.2v-12.7s48-10.5 55.8-13.2c7.8-2.8 10.4-2.9 17-.5s46.1 9.5 52.6 11.9v12.5c0 1.3-1.5 2.7-4.9 4.5z">
                        </path>
                        <path fill="#D82C20"
                            d="M121.8 59.8c-6.7 3.5-41.4 17.7-48.8 21.6-7.4 3.8-11.5 3.8-17.3 1-5.8-2.8-42.7-17.7-49.4-20.9s-6.8-5.4-.3-7.9c6.5-2.6 43.2-17 51-19.7 7.8-2.8 10.4-2.9 17-.5s41.1 16.1 47.6 18.5c6.7 2.4 6.9 4.4.2 7.9z">
                        </path>
                        <path fill="#A41E11"
                            d="M121.8 51c-6.7 3.5-41.4 17.7-48.8 21.6-7.4 3.8-11.5 3.8-17.3 1-5.8-2.7-42.7-17.6-49.4-20.8-3.3-1.6-5.1-2.9-5.1-4.2v-12.7s48-10.5 55.8-13.2c7.8-2.8 10.4-2.9 17-.5s46.1 9.5 52.6 11.9v12.5c.1 1.3-1.4 2.6-4.8 4.4z">
                        </path>
                        <path fill="#D82C20"
                            d="M121.8 38.3c-6.7 3.5-41.4 17.7-48.8 21.6-7.4 3.8-11.5 3.8-17.3 1s-42.7-17.6-49.4-20.8-6.8-5.4-.3-7.9c6.5-2.6 43.2-17 51-19.7 7.8-2.8 10.4-2.9 17-.5s41.1 16.1 47.6 18.5c6.7 2.4 6.9 4.4.2 7.8z">
                        </path>
                        <path fill="#fff"
                            d="M80.4 26.1l-10.8 1.2-2.5 5.8-3.9-6.5-12.5-1.1 9.3-3.4-2.8-5.2 8.8 3.4 8.2-2.7-2.2 5.4zM66.5 54.5l-20.3-8.4 29.1-4.4z">
                        </path>
                        <ellipse fill="#fff" cx="38.4" cy="35.4" rx="15.5" ry="6"></ellipse>
                        <path fill="#7A0C00" d="M93.3 27.7l17.2 6.8-17.2 6.8z"></path>
                        <path fill="#AD2115" d="M74.3 35.3l19-7.6v13.6l-1.9.8z"></path>
                    </g>
                </svg>
            </div>
            <div
                class="hidden md:flex h-16 w-16 rounded-full bg-white shadow items-center justify-center absolute right-0 top-1/4 -mr-16 mt-32">
                <svg class="w-10" viewBox="0 0 128 128">
                    <path fill="#6181B6"
                        d="M64 33.039c-33.74 0-61.094 13.862-61.094 30.961s27.354 30.961 61.094 30.961 61.094-13.862 61.094-30.961-27.354-30.961-61.094-30.961zm-15.897 36.993c-1.458 1.364-3.077 1.927-4.86 2.507-1.783.581-4.052.461-6.811.461h-6.253l-1.733 10h-7.301l6.515-34h14.04c4.224 0 7.305 1.215 9.242 3.432 1.937 2.217 2.519 5.364 1.747 9.337-.319 1.637-.856 3.159-1.614 4.515-.759 1.357-1.75 2.624-2.972 3.748zm21.311 2.968l2.881-14.42c.328-1.688.208-2.942-.361-3.555-.57-.614-1.782-1.025-3.635-1.025h-5.79l-3.731 19h-7.244l6.515-33h7.244l-1.732 9h6.453c4.061 0 6.861.815 8.402 2.231s2.003 3.356 1.387 6.528l-3.031 15.241h-7.358zm40.259-11.178c-.318 1.637-.856 3.133-1.613 4.488-.758 1.357-1.748 2.598-2.971 3.722-1.458 1.364-3.078 1.927-4.86 2.507-1.782.581-4.053.461-6.812.461h-6.253l-1.732 10h-7.301l6.514-34h14.041c4.224 0 7.305 1.215 9.241 3.432 1.935 2.217 2.518 5.418 1.746 9.39zM95.919 54h-5.001l-2.727 14h4.442c2.942 0 5.136-.29 6.576-1.4 1.442-1.108 2.413-2.828 2.918-5.421.484-2.491.264-4.434-.66-5.458-.925-1.024-2.774-1.721-5.548-1.721zM38.934 54h-5.002l-2.727 14h4.441c2.943 0 5.136-.29 6.577-1.4 1.441-1.108 2.413-2.828 2.917-5.421.484-2.491.264-4.434-.66-5.458s-2.772-1.721-5.546-1.721z">
                    </path>
                </svg>
            </div>
            <div
                class="hidden md:flex h-12 w-12 rounded-full bg-white shadow items-center justify-center absolute right-0 top-1/4 mr-16 mt-48">
                <svg class="w-8" viewBox="0 0 128 128">
                    <g fill="#090">
                        <path
                            d="M24.5 50.5c-1.5 0-2.5 1.2-2.5 2.7v14.1l-15.9-16c-.8-.8-2.2-1-3.2-.6s-1.9 1.4-1.9 2.5v20.7c0 1.5 1.5 2.7 3 2.7s3-1.2 3-2.7v-14.1l16.1 16c.5.5 1.2.8 1.9.8.3 0 .4-.1.7-.2 1-.4 1.3-1.4 1.3-2.5v-20.6c0-1.5-1-2.8-2.5-2.8zM44.2 62.3c-1.4 0-2.7 1.4-2.7 2.8s1.3 2.8 2.7 2.8l6.6.4-1.5 3.7h-8.5l-4.2-7.9 4.3-8.1h9.1l2.1 4h5.5l-3.6-7.9-.8-1.1h-15.6l-.7 1.2-5.9 10.3-.7 1.3.7 1.3 5.8 10.3.8 1.6h15.1l.7-1.7 4.3-9 1.9-4.3h-4.4l-11 .3zM65 50.5c-1.4 0-3 1.3-3 2.7v6.8h6v-6.7c0-1.5-1.6-2.8-3-2.8zM95.4 50.8c-1-.4-2.4-.2-3.1.6l-16.3 16v-14.1c0-1.5-1-2.7-2.5-2.7s-2.5 1.2-2.5 2.7v20.7c0 1.1.7 2.1 1.7 2.5.3.1.7.2 1 .2.7 0 1.6-.3 2.1-.8l16.2-16v14.1c0 1.5 1 2.7 2.5 2.7s2.5-1.2 2.5-2.7v-20.7c0-1.1-.6-2.1-1.6-2.5zM117.2 63.6l8.4-8.4c1.1-1.1 1.1-2.8 0-3.8-1.1-1.1-2.8-1.1-3.8 0l-8.4 8.4-8.4-8.4c-1.1-1.1-2.8-1.1-3.8 0-1.1 1.1-1.1 2.8 0 3.8l8.4 8.4-8.4 8.4c-1.1 1.1-1.1 2.8 0 3.8.5.5 1.2.8 1.9.8s1.4-.3 1.9-.8l8.4-8.4 8.4 8.4c.5.5 1.2.8 1.9.8s1.4-.3 1.9-.8c1.1-1.1 1.1-2.8 0-3.8l-8.4-8.4zM62 73.9c0 1.4 1.5 2.7 3 2.7 1.4 0 3-1.3 3-2.7v-11.9h-6v11.9z">
                        </path>
                    </g>
                </svg>
            </div>
            <!-- 右边图标圆点 -->

            <!-- 标题口号 -->
            <div class="relative py-8 md:py-12 text-center">
                <div class="max-w-lg mx-auto mb-8">
                    <h2 class="text-gray-1000 text-3xl md:text-5xl mb-4 font-bold">
                        <span>拟物校园</span>
                        <span class="inline-block pl-2 pr-4 relative text-white bg-brand-php"
                            style="border-radius: 91% 9% 90% 10% / 29% 82% 18% 71%" data-toggle="typed"
                            data-options='{"loop": true, "smartBackspace": false, "backDelay": 1000, "backSpeed": 50, "typeSpeed": 100, "showCursor": false, "strings": ["PHP", "Laravel", "Mysql", "Redis", "Nginx"]}'></span>
                    </h2>
                    <p class="text-gray-400 leading-relaxed">
                        拟物校园是一款开源的高校教务移动化系统，可快速对接正方，青果，URP等教务，方便学生在移动端查询个人信息，成绩，课表等。
                    </p>
                </div>
                <div>
                    <a class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 text-xs text-white text-center font-semibold leading-none bg-cyan-500 hover:bg-cyan-400 rounded"
                        href="{{ route('dcat.admin.login') }}">快速开始</a>
                </div>
            </div>
            <!-- 标题口号 -->
        </div>
        <!-- 标题口号容器 -->

        <!-- 项目主图 -->
        <div class="relative px-4 max-w-3xl mt-16 md:mt-8 mb-8 mx-auto">
            <!-- 左边彩色方块 -->
            <div class="hidden md:block absolute h-20 w-20 top-0 left-0 -ml-48 mt-12 rounded-xl bg-brand-green"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-32 w-20 top-0 left-0 -ml-20 mt-24 rounded-xl bg-brand-red"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-12 w-12 top-0 left-0 -ml-40 mt-40 rounded-bl-6xl bg-blue-600"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-24 w-20 bottom-0 left-0 -ml-20 mb-32 rounded-xl bg-brand-blue"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-24 w-20 bottom-0 left-0 -ml-20 rounded-bl-6xl rounded-tr-3xl bg-brand-yellow"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <!-- 左边彩色方块 -->

            <!-- 右边彩色方块 -->
            <div class="hidden md:block absolute h-12 w-12 top-0 right-0 -mr-40 mt-5 rounded-xl bg-brand-blue"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-40 w-20 top-0 right-0 -mr-20 mt-5 rounded-xl bg-brand-green"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-12 w-20 top-0 right-0 -mr-20 mt-48 rounded-b-6xl bg-brand-yellow"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-24 w-20 bottom-0 right-0 -mr-20 mb-32 rounded-bl-xl rounded-tr-6xl bg-brand-red"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <div class="hidden md:block absolute h-24 w-20 bottom-0 right-0 -mr-20 rounded-xl bg-brand-blue"
                style="visibility: visible; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transition: opacity 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s, transform 1.35s cubic-bezier(0.5, 0, 0, 1) 0.2s;">
            </div>
            <!-- 右边彩色方块 -->
            <div class="sm:px-8 pt-4 sm:pt-9 w-full lg:min-h-hero relative">
                <img class="rounded-xl shadow" src="{{ URL::asset('vendor/index/images/dashboard.png') }}" alt="">
            </div>
        </div>
        <!-- 项目主图 -->
    </section>
    <!-- 主页 -->

    <!-- 功能介绍页面 -->
    <section class="text-gray-900">
        <div class="container px-5 mt-20 mx-auto">
            <div class="text-center mb-20">
                <h1 class="md:text-3xl text-2xl font-semibold">特性</h1>
            </div>

            <!-- 功能容器 -->
            <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4 md:space-y-0 space-y-6">

                <div class="p-4 md:w-1/4 w-full">
                    <div
                        class="p-4 h-full flex flex-col text-center items-center relative order-gray-200 rounded-lg bg-white shadow">
                        <img class="hidden md:block absolute -bottom-1/10 -left-1/4 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-blue.svg') }}">
                        <img class="hidden md:block absolute -bottom-1/10 -left-1/3 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-orange.svg') }}">
                        <div
                            class="hidden md:block absolute -top-1/10 -left-1/10  w-32 h-32 bg-brand-red rounded-tl-3xl rounded-bl-lg rounded-tr-lg -z-10">
                        </div>

                        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full mb-5 flex-shrink-0">
                            <svg class="w-16" viewBox="0 0 1024 1024">
                                <path
                                    d="M498.603 191.744a204.715 204.715 0 0 1 116.906 372.8c133.163 47.317 229.078 173.29 231.894 322.027l0.085 6.784h-64c0-157.334-127.573-284.886-284.885-284.886-155.136 0-281.302 123.968-284.822 278.251l-0.085 6.613h-64c0-151.68 96.81-280.746 232-328.81a204.715 204.715 0 0 1 116.907-372.8z m0 64a140.715 140.715 0 1 0 0 281.45 140.715 140.715 0 0 0 0-281.45z"
                                    fill="#13c2c2" p-id="1123"></path>
                            </svg>
                        </div>

                        <div class="flex-grow">
                            <h2 class="font-semibold text-xl mb-3">个人信息</h2>
                            <p class="leading-relaxed text-base text-gray-400">可以获取学生班级，专业，学院等个人信息。</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 md:w-1/4 w-full">
                    <div
                        class="p-4 h-full flex flex-col text-center items-center relative order-gray-200 rounded-lg bg-white shadow">
                        <img class="hidden md:block absolute -top-1/10 -left-1/4 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-green.svg') }}">
                        <img class="hidden md:block absolute -top-1/10 -left-1/3 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-blue.svg') }}">
                        <div
                            class="hidden md:block absolute -bottom-1/10 -right-1/10 w-32 h-32 bg-brand-yellow rounded-br-3xl rounded-bl-lg rounded-tr-lg -z-10">
                        </div>

                        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full mb-5 flex-shrink-0">
                            <svg class="w-16" viewBox="0 0 1024 1024">
                                <path
                                    d="M654.827 117.333L864 326.507V928H160V117.333h494.827z m-68.16 63.979H224V864h576V394.667H586.667V181.333zM704 672v64H320v-64h384z m0-170.667v64H320v-64h384zM500.736 330.667v64H320v-64h180.736z m276.928 0L650.667 203.669v126.998h126.997z"
                                    fill="#13c2c2" p-id="1251"></path>
                            </svg>
                        </div>

                        <div class="flex-grow">
                            <h2 class="font-semibold text-xl mb-3">成绩</h2>
                            <p class="leading-relaxed text-base text-gray-400">可以获取学生成绩，绩点，学分等信息。</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 md:w-1/4 w-full">
                    <div
                        class="p-4 h-full flex flex-col text-center items-center relative order-gray-200 rounded-lg bg-white shadow">
                        <img class="hidden md:block absolute -bottom-1/10 -right-1/4 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-red.svg') }}">
                        <img class="hidden md:block absolute -bottom-1/10 -right-1/3 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-green.svg') }}">
                        <div
                            class="hidden md:block absolute -top-1/10 -left-1/10 w-32 h-32 bg-brand-green rounded-tl-3xl rounded-bl-lg rounded-tr-lg -z-10">
                        </div>

                        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full mb-5 flex-shrink-0">
                            <svg class="w-16" viewBox="0 0 1024 1024">
                                <path
                                    d="M714.667 117.333v64h170.666v704H138.667v-704h170.666v-64h405.334z m-405.334 128H202.667v576h618.666v-576H714.667v64H309.333v-64zM704 618.667v64H320v-64h384z m0-192v64H320v-64h384z m-53.333-245.334H373.333v64h277.334v-64z"
                                    fill="#13c2c2" p-id="1379"></path>
                            </svg>
                        </div>

                        <div class="flex-grow">
                            <h2 class="font-semibold text-xl mb-3">课表</h2>
                            <p class="leading-relaxed text-base text-gray-400">可以获取学生课表，时间，地点等信息。</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 md:w-1/4 w-full">
                    <div
                        class="p-4 h-full flex flex-col text-center items-center relative order-gray-200 rounded-lg bg-white shadow">
                        <img class="hidden md:block absolute -top-1/10 -right-1/4 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-orange.svg') }}">
                        <img class="hidden md:block absolute -top-1/10 -right-1/3 h-32 -z-10"
                            src="{{ URL::asset('vendor/index/images/material/dots-full-red.svg') }}">
                        <div
                            class="hidden md:block absolute -bottom-1/10 -right-1/10 w-32 h-32 bg-brand-blue rounded-br-3xl rounded-bl-lg rounded-tr-lg -z-10">
                        </div>

                        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full mb-5 flex-shrink-0">
                            <svg class="w-16" viewBox="0 0 1024 1024">
                                <path
                                    d="M746.667 842.667v64H277.333v-64h469.334z m160-704v618.666H117.333V138.667h789.334z m-64 64H181.333v490.666h661.334V202.667zM384 419.072v149.333h-64V419.072h64z m160-85.333v234.666h-64V333.74h64z m160 64v170.666h-64V397.74h64z"
                                    fill="#13c2c2" p-id="1507"></path>
                            </svg>
                        </div>

                        <div class="flex-grow">
                            <h2 class="font-semibold text-xl mb-3">后台</h2>
                            <p class="leading-relaxed text-base text-gray-400">后台可配置学校信息，操作学生信息，学生成绩，学生课表等。</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- 功能容器 -->
        </div>
    </section>
    <!-- 功能介绍页面 -->

    <!-- 支持院校页 -->
    <section class="text-gray-900">
        <div class="container px-5 mt-20 mb-20 mx-auto">
            <div class="text-center mb-20">
                <h1 class="md:text-3xl text-2xl font-semibold">支持院校</h1>
            </div>

            <!-- 支持院校容器 -->
            <div class="flex flex-wrap -m-2">

                @if (count($schools) >= 1)
                    @foreach ($schools as $index => $school)
                    @break($index >= 9)

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg shadow">
                            <img src="{{ $school->icon }}" alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4">
                            <div class="flex-grow">
                                <h2 class="font-semibold">{{ $school->name }}</h2>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
            <!-- 支持院校容器 -->
        </div>
    </section>
    <!-- 支持院校页 -->

    <!-- 页脚页 -->
    <section class="bg-gray-800 text-gray-100">
        <div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
            <a class="flex title-font font-medium items-center md:justify-start justify-center">
                <img class="h-10 rounded-lg" src="{{ URL::asset('vendor/index/images/logo.jpg') }}" alt=""
                    width="auto">
                <span class="ml-3 text-xl">拟物工作室</span></span>
            </a>

            <p class="text-sm sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">© 2021 nivin.cn</p>

            <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
                <a class=""></a>
                <a class="ml-3"></a>
                <a class="ml-3"></a>
                <a class="ml-3"></a>
            </span>

        </div>
    </section>
    <!-- 页脚页 -->
</body>

</html>
