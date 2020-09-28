<template>
  <div class="centered">
    <div class="vertical-center">
      <div class="inner-block">
        <h3>Coporate Contacts</h3>
        <slot />
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
  .navbar-light {
    background-color: #ffffff;
    box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
  }

  .centered {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .inner-block {
    width: 450px;
    // margin: auto;
    background: #ffffff;
    box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
    padding: 40px 55px 45px 55px;
    border-radius: 15px;
    transition: all .3s;
  }

  .vertical-center {
    h3 {
      text-align: center;
      margin: 0;
      line-height: 1;
      padding-bottom: 20px;
    }
    .form-control:focus {
      border-color: gray;
      box-shadow: none;
    }
  }

  label {
    font-weight: 500;
  }
</style>
