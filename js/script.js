var SKI = SKI || {};

(function (self, $) {

  var $angleSlider,
    $angleAmount,
    $powerSlider,
    $powerAmount,
    $fireButton,
    $lockButton;
  
  self.init = function () {
    $angleSlider = $('#angle');
    $angleAmount = $('#angleAmount');
    $powerSlider = $('#power');
    $powerAmount = $('#powerAmount');
    $lockButton = $('#lockButton');
    $fireButton = $('#fireButton');

    // Angle slider
    $angleAmount.html($angleSlider.val() + '&deg;');
    $angleSlider.change(function () {
      $angleAmount.html($angleSlider.val() + '&deg;');
    });
    
    // Power slider
    $powerAmount.html($powerSlider.val() + '&deg;');
    $powerSlider.change(function () {
      $powerAmount.html($powerSlider.val() + '&deg;');
    });


    $('#lockButton:not(disabled)').click(function (e) {
      $lockButton.val('Locking...').prop('disabled', true);
      $fireButton.prop('disabled', true); // Disable the fire button

      // run the request
      $.ajax({
        type: 'GET',
        url: 'php/teleduino-API.php',
        data: {
          power: $powerSlider.val(),
          angle: $angleSlider.val()
        },
        success: function () {

          // Ensure that we cannot fire until the timer has restarted
          $fireButton.off('click.test');

          // Unlock the stuff!
          var timer = setTimeout(function () {
            $lockButton.val('Lock').prop('disabled', false);
            $fireButton.prop('disabled', false);

            // Bind click events
            $fireButton.on('click.test', function (e) {
              $.ajax({
                type: 'GET',
                url: 'php/teleduino-API.php',
                data: {
                  fire: 1
                },
                success: function () {
                  // re-disable the fire button
                  $fireButton.attr('disabled', true);
                  $('#fireButton').off('click.test');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error! Check if the php script is being referenced correctly.');
                }
              })
            });
          }, 2000);

        },
        error: function () {
          alert('Error! Check if the php script is being referenced correctly.');
        }
      });

      e.preventDefault();
    });
  };

}(SKI.controls = {}, jQuery));

$(document).ready(function () {
  SKI.controls.init();
});
