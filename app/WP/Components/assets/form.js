var imwp = imwp || {};

// 触发自定义事件
imwp.emit = function (el, name) {
  el.dispatchEvent(new Event(name));
};

imwp.formImage = {
  // 父节点触发已上传事件
  upload: function (el) {
    if (typeof el.media === 'undefined') {
      el.media = wp.media({ library: { type: 'image' }, multiple: false });
      el.parentNode.media = el.media;
      el.media.on('select', function () {
        imwp.emit(el.parentNode, 'select');
        var image = el.media.state().get('selection').first().attributes;
        var input = el.parentNode.querySelector('input');
        var img = el.parentNode.querySelector('img');
        if (!img) {
          img = document.createElement('img');
          el.parentNode.insertBefore(img, el.parentNode.firstChild);
        }
        img.setAttribute('src', image.url);
        if (input) input.setAttribute('value', image.id);
        imwp.emit(el.parentNode, 'uploaded');
      });
    }
    el.media.open();
  },
  // 父节点触发取消事件
  cancel: function (el) {
    var input = el.parentNode.querySelector('input');
    var img = el.parentNode.querySelector('img');
    if (img) el.parentNode.removeChild(img);
    if (input) input.setAttribute('value', '');
    imwp.emit(el.parentNode, 'cancel');
  },
};

imwp.FormImageGroup = function (el) {
  this.el = el;
  this.count = el.getAttribute('data-count') || 1;
  this.defField = el.querySelector('.image-field.empty');
  this.input = this.defField.querySelector('input');
  this.input.remove();
  this.defField.remove();
  this.defField.style.display = '';
  this.images().forEach(function (el) {
    this.addEvents(el);
  });
  this.checkLen();
};

imwp.FormImageGroup.prototype.images = function () {
  return this.el.querySelectorAll('.image-field');
};

imwp.FormImageGroup.prototype.checkLen = function () {
  if (this.images().length < this.count && !this.el.querySelector('.image-field.empty')) {
    var image = this.defField.cloneNode(true);
    this.addEvents(image);
    this.el.appendChild(image);
  }
};

imwp.FormImageGroup.prototype.addEvents = function (image) {
  var self = this;
  image.addEventListener('select', function () {
    this.appendChild(self.input.cloneNode());
  });
  image.addEventListener('uploaded', function () {
    this.classList.remove('empty');
    self.checkLen();
  });
  image.addEventListener('cancel', function () {
    this.remove();
    self.checkLen();
  });
};

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.image-field-group').forEach(function (el) {
    new imwp.FormImageGroup(el);
  });
});
