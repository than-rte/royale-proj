<template>
  <div class="card">
    <div class="card-header has-background-link-light">
      <h5 class="card-header-title">
        <slot name="header"></slot>
      </h5>
    </div>
    <slot></slot>
    <slot name="footer"></slot>
  </div>
</template>
