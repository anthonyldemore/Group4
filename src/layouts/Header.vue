<template>
  <div>
    <b-nav tabs>
        <b-nav-item >Active</b-nav-item>
        <b-nav-item>Link</b-nav-item>
        <b-nav-item>Another Link</b-nav-item>
        <b-nav-item disabled>Disabled</b-nav-item>
    </b-nav>
    <b-container class="customer-container">
      <b-row>
        <b-col>
          <b-col>
            <slot> </slot>
          </b-col>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
