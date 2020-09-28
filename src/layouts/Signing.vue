<template>
  <div class= "container">
  <div class="centered">
    <div class="vertical-center">
      <h1> Corporate Contacts <img src="../../images/CorpContacts.png" style="vertical-align:top" alt=""></h1>
      <div class="inner-block">
        <slot />
      </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.container
{
 @media (min-width: 320px){
   img
   {
     width: 30px;
     height: 30px;
     margin-top: 5px;
     margin-left: 5px;
    //  filter: drop-shadow(1px 2px 4px white);
   }
    h1 {
        font-size: 28px;
        align-self: flex-start;
       }
    .inner-block
    {
      width: 300px;
      max-height: 500px;
    }
    h5
    {
      font-size: 15px;
    }
    .form-group
    {
      height: 66px;
    }
    .table
    {
      width: 200px;
    }
  }
}
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
    padding: 10px 15px 1px 15px;
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

  // label {
  //   font-weight: 550;
  // }
  .username
{
  padding-top: 8px;
}
</style>

<style>
h1
{
  text-align: center;
  padding-bottom: 5%;
  color: rgb(24, 66, 30);
  text-shadow: 4px 5px 8px rgb(120, 102, 202);
}
</style>
