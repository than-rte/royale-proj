<template>
    <fragment>
        <header class="py-4 has-shadow">
            <div class="container is-fluid is-flex">
                <div>
                    <img
                        src="http://localhost:8000/brand.png"
                        alt="Royale Emelina Logo"
                    />
                </div>
                <div
                    class="is-flex is-flex-direction-column is-justify-content-center ml-4"
                >
                    <h1 class="title">Royale Emelina Events & Venues</h1>
                    <h2 class="subtitle">
                        Lorem ipsum dolor sit amet consectetur,
                    </h2>
                </div>
            </div>
        </header>
        <div class="container is-fluid py-2">
            <nav class="navbar" role="navigation" aria-label="main navigation">
                <div class="navbar-start">
                    <a class="navbar-item"> Dashboard </a>
                    <a class="navbar-item"> Schedules </a>
                    <a class="navbar-item is-active"> Venues </a>
                    <a class="navbar-item"> Events </a>
                    <a class="navbar-item"> Media </a>
                </div>
            </nav>
        </div>
    </fragment>
</template>

<style scoped>
.navbar-item.is-active {
    color: #7957d5;
}
</style>
