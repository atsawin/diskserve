$(document).ready(function() {
  $(this).initToggle();
});

// Toggles. support for radio, select and autoLookup
jQuery.fn.initToggle = function() {
  $(this).showFirstSelect();
  $(this).showChangeSelect();
}

jQuery.fn.showFirstSelect = function() {
  $('div[blockName],tr[blockName]').hide();
  $('div[blockName],tr[blockName]').find(':input').attr('disabled', 'disabled');
  $("div[blockName],tr[blockName]").each(function() {
    // All toggleBlocks
    if ($(this).parents('[blockName]').size() == 0) {
      // Only outermost toggleBlocks
      $(this).updateSubToggle();
    }
  });
}

jQuery.fn.showChangeSelect = function() {
  $('select[Toggle]').each(function() {
    //console.log(this);
    $(this).change(function() {
      var self = $(this);
      //console.log('tname='+self.attr('Toggle'));
      $('[blockName="'+self.attr('Toggle')+'"]').hide();
      $('[blockName="'+self.attr('Toggle')+'"] :input').attr('disabled', 'disabled');
      $('[blockName="'+self.attr('Toggle')+'"]').each(function() {
        $(this).updateSubToggle();
      });
    });
  });
  $('div[radioToggle] input:radio').each(function() {
    //console.log(this);
    $(this).change(function() {
      var self = $(this).parent();
      //console.log('tname='+self.attr('radioToggle'));
      $('[blockName="'+self.attr('radioToggle')+'"]').hide();
      $('[blockName="'+self.attr('radioToggle')+'"] :input').attr('disabled', 'disabled');
      $('[blockName="'+self.attr('radioToggle')+'"]').each(function() {
        $(this).updateSubToggle();
      });
    });
  });
}

jQuery.fn.displayToggle = function() {
  var self = $(this);
  //console.log('show blockName='+self.attr('blockName')+', blockValues='+self.attr('blockValues'));
  self.show();
  var excludeInputsArray = $('[blockName] :input', self);
  var excludeGridHiddensArray = $('span[kel=submitParams] input[type=submit],span[kel=submitParams] input[type=image]', self).siblings('input[type=hidden]');
  //console.log(excludeInputsArray);
  $(':input', self).each(function() {
    if (($.inArray(this, excludeInputsArray) == -1) && ($.inArray(this, excludeGridHiddensArray) == -1)) {
      $(this).removeAttr('disabled');
      //console.log('show input: '+$(this).attr('name'));
    }
  });
  var subToggle = []
  $('[blockName]', self).each(function() {
    //console.log('push: '+$(this).attr('blockName')+' from: '+self.attr('blockName')+' parent: '+$($(this).parents('[blockName]').get(0)).attr('blockName'));
    if (($.inArray($(this).attr('blockName'), subToggle) < 0) && ($($(this).parents('[blockName]').get(0)).attr('blockName') == self.attr('blockName'))) {
      //console.log('pushed!');
      subToggle.push($(this).attr('blockName'));
    }
  });
  for (var i = 0; i < subToggle.length; i++) {
    $("[blockName="+subToggle[i]+"]", self).each(function() {
      //console.log('called from: '+self.attr('blockName')+' '+self.attr('blockValues'));
      $(this).updateSubToggle();
    });
  }
}

jQuery.fn.updateSubToggle = function() {
  var self = $(this);
  //console.log('updateSubToggle: '+self.attr('blockName')+' '+self.attr('blockValues'));
  var currentValue = 'SHOULD NOT FOUND';
  var blockValuesArray = self.attr('blockValues').split(',');
  //console.log(blockValuesArray);
  var parent = self.parent();
  if (parent.attr('tagName') == 'TBODY') {
    parent = parent.parent();
  }
  if (parent.is(':visible')) {
    var sourceToggle = $('[Toggle="'+self.attr('blockName')+'"]');
    if (sourceToggle.attr('type') == 'select-one') {
      //console.log(self.attr('blockValues')+':'+sourceToggle.attr('name')+':'+sourceToggle.attr('type'));
      currentValue = sourceToggle.val();
    }
    var sourceToggle = $('div[radioToggle="'+self.attr('blockName')+'"] input:radio');
    if (sourceToggle) {
      //console.log(self.attr('blockValues')+':'+sourceToggle.attr('name')+':'+sourceToggle.attr('type'));
      currentValue = sourceToggle.filter(':checked').val();
    }
  }
  //console.log(currentValue);
  if ($.inArray(currentValue, blockValuesArray) > -1) {
    // Show block
    self.displayToggle();
  } else {
    //console.log('self.hide'+self.attr('blockName'));
    self.hide();
    //console.log($(':input', self));
    $(':input', self).attr('disabled', 'disabled');
  }
}

