

<div class="modal fade" id="payment-qrcode-modal" tabindex="-1" role="" aria-labelledby="exampleModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="exampleModalLabel">
            <img src="{{ $topic->user->present()->gravatar }}" style="width:65px; height:65px;" class="img-thumbnail avatar" />
        </h4>
      </div>

        <div class="modal-body text-center">
            <p class="text-md">
                Se você acha que meu artigo é útil para você, sinta-se à vontade para pedir. Seu apoio me incentivará a continuar criando!
            </p>
            <img class="payment-qrcode" src="{{ $topic->user->payment_qrcode }}" alt="" style="width:320px;height:320px"/>
            <hr>
            <p style="color: #898989;">
                Por favor, use WeChat para digitalizar o código QR.<a href="https://h3sotospeak.com/topics/2487" target="_blank" style="color: #898989;text-decoration: underline;">Como abrir uma recompensa？</a>
            </p>
        </div>

    </div>
  </div>
</div>

