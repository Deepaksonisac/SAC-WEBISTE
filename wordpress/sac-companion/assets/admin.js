/* Media Library picker for SAC Site Settings image fields. */
jQuery(function ($) {
  $(document).on('click', '.sac-img-pick', function (e) {
    e.preventDefault()
    var field = $(this).closest('.sac-img-field')
    var frame = wp.media({ title: 'Select image', library: { type: 'image' }, multiple: false })
    frame.on('select', function () {
      var item = frame.state().get('selection').first().toJSON()
      var url = item.sizes && item.sizes.medium ? item.sizes.medium.url : item.url
      field.find('input[type=hidden]').val(item.id)
      field.find('.sac-img-preview').html($('<img alt="">').attr('src', url))
    })
    frame.open()
  })
  $(document).on('click', '.sac-img-clear', function (e) {
    e.preventDefault()
    var field = $(this).closest('.sac-img-field')
    field.find('input[type=hidden]').val('')
    field.find('.sac-img-preview').empty()
  })
})
