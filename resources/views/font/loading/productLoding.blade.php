<style>
    .Pageloading {
        z-index: 10000;
        /* background-color: black; */
        color: white;
        opacity: 0.5;
        font-family: PT Sans Narrow;
        font-size: 30px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mainLoding {
        content: url("{{ asset('asset/image/Spinner-1s-200px.gif') }}");
    }

    .Pageloading:after {
        overflow: hidden;
        display: inline-block;
        vertical-align: bottom;
        /* -webkit-animation: ellipsis steps(5,end) 1000ms infinite; */
        /* animation: ellipsis steps(5,end) 1000ms infinite; */
        content: "\2026\2026";
        /* ascii code for the ellipsis character */
        width: 0px;
    }

    @keyframes ellipsis {
        to {
            width: 1.15em;
        }
    }

    @-webkit-keyframes ellipsis {
        to {
            width: 1.5em;
        }
    }

    /* .Pageloading {
        width: 100px;
        height: 100px;
        background-color: red;
        z-index: 10000;
        position: absolute;
        top: 430px;
        bottom: 0;
        left: 0;
        right: 0;

        margin: auto;
    } */

</style>
<div class="Pageloading">
    <div class="mainLoding"></div>
</div>
