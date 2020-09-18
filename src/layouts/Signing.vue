<template>
  <div class="centered">
    <div class="vertical-center">
      <div class="inner-block">
        <h3>Corporate Contacts</h3>
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
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
  }
  .inner-block {
    width: 400px;
    height: 30%;
    background: #ffffff;
    box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
    padding: 15px 40px 1px 35px;
    border-radius: 25px;
  }

  .vertical-center {
    h3 {
      text-align: center;
      margin: 0;
      line-height: 1;
      padding-bottom: 5px;
    }
    .form-control:focus {
      border-color: rgb(203, 214, 218);
      box-shadow: none;
    }

     h5 {
      text-align: center;
      margin: 0;
      line-height: 1;
      padding-top: 2px;
      padding-bottom: 5px;
    }
  }

  label {
    font-weight: 550;
  }
</style>
