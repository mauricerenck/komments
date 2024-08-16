(function() {
  "use strict";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main$7 = {
    props: {
      queuedKomments: Object,
      affectedPages: Array
    },
    data() {
      return {
        pagination: {
          page: 1,
          limit: 20,
          total: 0
        }
      };
    },
    computed: {
      index() {
        return (this.pagination.page - 1) * this.pagination.limit + 1;
      },
      commentList() {
        const commentList = [];
        this.pagination.total = 0;
        this.queuedKomments.filter((comment) => !comment.published).forEach((comment) => {
          const pageOfComment = this.affectedPages.find((page) => page.uuid === comment.pageuuid);
          const newComment = {
            id: comment.id,
            pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
            author: `<span class="author-entry"><img src="${comment.authoravatar}" width="30px" height="30px" />${comment.authorname}</span>`,
            content: comment.content,
            updatedAt: comment.updatedat,
            spamlevel: comment.spamlevel > 0 ? '<svg aria-hidden="true" data-type="flag" class="k-icon" style="color: var(--color-red-700);"><use xlink:href="#icon-flag"></use></svg>' : "",
            verified: comment.verified ? '<svg aria-hidden="true" data-type="sparkling" class="k-icon" style="color: var(--color-green-700);"><use xlink:href="#icon-sparkling"></use></svg>' : ""
          };
          commentList.push(newComment);
          this.pagination.total++;
        });
        return commentList.slice(this.index - 1, this.pagination.limit * this.pagination.page);
      }
    },
    methods: {
      showCommentDetails(id) {
        const comment = this.queuedKomments.find((comment2) => comment2.id === id);
        panel.drawer.open({
          component: "komments-detail-drawer",
          props: {
            icon: "info",
            title: "Comment",
            comment
          }
        });
      },
      replyToComment(id) {
        const comment = this.queuedKomments.find((comment2) => comment2.id === id);
        panel.drawer.open({
          component: "komments-reply-drawer",
          props: {
            icon: "chat",
            title: "Reply to comment",
            comment
          }
        });
      },
      publishComment(id) {
        panel.api.post(`komments/publish/${id}`).then((response) => {
          this.queuedKomments.find((item) => item.id === id).published = response.published;
        });
      },
      deleteComment(id) {
        panel.dialog.open(`comment/delete/${id}`);
      },
      flagComment(id, type) {
        panel.api.post(`komments/flag/${id}/${type}`).then((response) => {
          this.queuedKomments.find((item) => item.id === id)[type] = response[type];
        });
      },
      dropdownOptions(row) {
        const comment = this.queuedKomments.find((item) => item.id === row.id);
        return [
          {
            label: comment.published ? "Unpublish" : "Publish",
            icon: comment.published ? "toggle-on" : "toggle-off",
            click: () => this.publishComment(row.id)
          },
          {
            label: "Reply to",
            icon: "chat",
            click: () => this.replyToComment(row.id)
          },
          "-",
          {
            label: comment.verified ? "Mark as unverified" : "Mark as verified",
            icon: comment.verified ? "cancel-small" : "sparkling",
            disabled: comment.spamlevel > 0,
            click: () => this.flagComment(row.id, "verified")
          },
          {
            label: comment.spamlevel > 0 ? "Remove from spam" : "Mark as spam" + row.spamlevel,
            icon: comment.spamlevel > 0 ? "cancel-small" : "flag",
            click: () => this.flagComment(row.id, "spamlevel")
          },
          {
            label: "View Details",
            icon: "info",
            click: () => this.showCommentDetails(row.id)
          },
          "-",
          {
            label: "Delete",
            icon: "trash",
            click: () => this.deleteComment(row.id)
          }
        ];
      }
    }
  };
  var _sfc_render$7 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-inside", [_c("div", { staticClass: "k-komments-view" }, [_c("k-headline", { attrs: { "tag": "h2" } }, [_vm._v("Comments")]), _c("k-table", { attrs: { "columns": {
      author: { label: "Author", type: "html" },
      content: { label: "Comment", type: "text" },
      pageTitle: { label: "Page", type: "html" },
      updatedAt: { label: "Last Update", type: "html" },
      spamlevel: { label: "Spamlevel", type: "html", width: "40px", align: "center" },
      verified: { label: "Verified", type: "html", width: "40px", align: "center" }
    }, "index": true, "rows": this.commentList, "pagination": { page: _vm.pagination.page, limit: _vm.pagination.limit, total: _vm.pagination.total, details: true } }, on: { "paginate": function($event) {
      _vm.pagination.page = $event.page;
    } }, scopedSlots: _vm._u([{ key: "header", fn: function({ columnIndex, label }) {
      return [_c("span", { attrs: { "title": label } }, [columnIndex === "verified" ? _c("k-icon", { staticStyle: { "color": "var(--color-yellow-700)" }, attrs: { "type": "sparkling" } }) : columnIndex === "spamlevel" ? _c("k-icon", { staticStyle: { "color": "var(--color-red-700)" }, attrs: { "type": "flag" } }) : _c("span", [_vm._v(_vm._s(label))])], 1)];
    } }, { key: "options", fn: function({ row }) {
      return [_c("k-options-dropdown", { attrs: { "options": _vm.dropdownOptions(row) } })];
    } }]) })], 1)]);
  };
  var _sfc_staticRenderFns$7 = [];
  _sfc_render$7._withStripped = true;
  var __component__$7 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$7,
    _sfc_render$7,
    _sfc_staticRenderFns$7
  );
  __component__$7.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/View.vue";
  const View = __component__$7.exports;
  const _sfc_main$6 = {
    mixins: ["drawer"],
    props: {
      comment: {
        type: Object,
        default: {}
      }
    }
  };
  var _sfc_render$6 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-drawer", _vm._b({}, "k-drawer", _vm.$props, false), [_c("CommentContent", { attrs: { "spamlevel": _vm.comment.spamlevel, "content": _vm.comment.content } }), _c("div", { staticClass: "k-table" }, [_c("table", { staticStyle: { "table-layout": "auto" } }, [_c("tbody", [_c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Id")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.id))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Type")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.type))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Language")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.language))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Published")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.published))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Verified")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.verified))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Reply To")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.parentid))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Spam level")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.spamlevel))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Upvotes")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.upvotes))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Downvotes")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.downvotes))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Created at")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.createdat))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Updated at")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.updatedat))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Permalink")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.permalink))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Author")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorname))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Avatar")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authoravatar))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Email")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authoremail))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Url")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorurl))])])])])])], 1);
  };
  var _sfc_staticRenderFns$6 = [];
  _sfc_render$6._withStripped = true;
  var __component__$6 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$6,
    _sfc_render$6,
    _sfc_staticRenderFns$6
  );
  __component__$6.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/DrawerDetails.vue";
  const DrawerDetails = __component__$6.exports;
  const _sfc_main$5 = {
    mixins: ["drawer"],
    props: {
      comment: {
        type: Object,
        default: {}
      }
    },
    data() {
      return {
        originPublished: this.comment.published,
        replyCreated: null,
        isSending: false
      };
    },
    methods: {
      sendReply() {
        this.isSending = true;
        panel.api.post(`komments/reply/${this.comment.id}`, {
          content: this.content,
          pageUuid: this.comment.pageuuid,
          language: this.comment.language
        }).then((response) => {
          this.originPublished = response["published"];
          this.replyCreated = response["created"];
          this.isSending = false;
        }).catch(() => {
          this.replyCreated = false;
          this.isSending = false;
        });
      }
    }
  };
  var _sfc_render$5 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-drawer", _vm._b({}, "k-drawer", _vm.$props, false), [!this.originPublished ? _c("k-box", { key: "unpublished", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "notice", "text": "This comment is not published yet. When you reply, it will be published along with your reply." } }) : _vm._e(), this.replyCreated ? _c("k-box", { key: "created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "positive", "text": "Your reply has been published." } }) : this.replyCreated === false ? _c("k-box", { key: "not-created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "negative", "text": "Your reply could not be published. Please try again." } }) : _vm._e(), _c("CommentContent", { attrs: { "spamlevel": _vm.comment.spamlevel, "content": _vm.comment.content } }), _c("k-writer-field", { staticStyle: { "margin-bottom": "var(--spacing-1)" }, attrs: { "autofocus": true, "label": `Reply to ${_vm.comment.authorname}`, "value": _vm.content }, on: { "input": function($event) {
      _vm.content = $event;
    } } }), _c("k-button", { key: "green", attrs: { "theme": "green", "variant": "filled", "icon": _vm.isSending ? _vm.loader : null, "disabled": _vm.isSending }, on: { "click": this.sendReply } }, [_vm._v(" Send reply ")])], 1);
  };
  var _sfc_staticRenderFns$5 = [];
  _sfc_render$5._withStripped = true;
  var __component__$5 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$5,
    _sfc_render$5,
    _sfc_staticRenderFns$5
  );
  __component__$5.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/DrawerReply.vue";
  const DrawerReply = __component__$5.exports;
  const _sfc_main$4 = {
    props: {
      spamlevel: Number,
      content: String
    }
  };
  var _sfc_render$4 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_vm.spamlevel > 0 ? _c("k-box", { key: "spam", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "warning", "text": "This comment is marked as spam. Its content is shown as plain text to prevent accidental exposure to harmful content." } }) : _vm._e(), _c("k-box", { staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "text" } }, [_vm.spamlevel === 0 ? _c("k-text", { domProps: { "innerHTML": _vm._s(_vm.content) } }) : _c("k-text", [_vm._v(_vm._s(_vm.content))])], 1)], 1);
  };
  var _sfc_staticRenderFns$4 = [];
  _sfc_render$4._withStripped = true;
  var __component__$4 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$4,
    _sfc_render$4,
    _sfc_staticRenderFns$4
  );
  __component__$4.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/CommentContent.vue";
  const CommentContent = __component__$4.exports;
  const _sfc_main$3 = {
    props: {
      komment: Object,
      onMarkAsSpam: Function,
      onMarkAsVerified: Function,
      onMarkAsPublished: Function,
      onDelete: Function,
      kommentApi: Function
    },
    methods: {
      markAsSpam(pageSlug, kommentId, isSpam) {
        this.komment.spamlevel = null;
        this.kommentApi().post("komments/spam", {
          pageSlug,
          kommentId,
          isSpam
        }).then(() => {
          this.onMarkAsSpam(isSpam);
        });
      },
      markAsVerified(pageSlug, kommentId, isVerified) {
        this.komment.verified = null;
        this.kommentApi().post("komments/verify", {
          pageSlug,
          kommentId,
          isVerified
        }).then(() => {
          this.onMarkAsVerified(isVerified);
        });
      },
      publish(pageSlug, kommentId, isPublished) {
        this.komment.status = null;
        this.kommentApi().post("komments/publish", {
          pageSlug,
          kommentId,
          isPublished
        }).then(() => {
          this.onMarkAsPublished(isPublished);
        });
      },
      deleteKomment(pageSlug, kommentId, ref) {
        this.kommentApi().post("komments/delete", {
          pageSlug,
          kommentId
        }).then(() => {
          this.onDelete();
          ref.deleteDialog.close();
        });
      },
      nl2br(kommentText) {
        return kommentText.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, "$1<br />$2");
      }
    }
  };
  var _sfc_render$3 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "komment-moderation" }, [_vm.komment.id ? _c("div", [_c("div", { staticClass: "metadata" }, [_c("div", { staticClass: "avatar" }, [_vm.komment.image ? _c("img", { attrs: { "src": _vm.komment.image } }) : _vm._e()]), _c("div", { staticClass: "komment-info" }, [_c("div", { staticClass: "author-short" }, [_c("strong", [_vm._v(_vm._s(_vm.komment.author))]), _vm.komment.authorUrl ? _c("k-link", { attrs: { "to": _vm.komment.authorUrl, "title": _vm.komment.authorUrl, "target": "_blank" } }, [_c("k-icon", { attrs: { "type": "url" } })], 1) : _vm._e()], 1), _c("div", { staticClass: "meta" }, [_vm._v(_vm._s(_vm.komment.published))]), _c("div", { staticClass: "meta" }, [_c("k-link", { attrs: { "to": _vm.komment.url, "title": _vm.komment.url } }, [_vm._v(_vm._s(_vm.komment.title))])], 1)])]), _c("div", { staticClass: "actions" }, [_c("div", { staticClass: "left" }, [_vm.komment.status === true ? _c("k-button", { staticClass: "publish", attrs: { "theme": "positive", "icon": "circle-filled" }, on: { "click": function($event) {
      return _vm.publish(_vm.komment.slug, _vm.komment.id, false);
    } } }, [_vm._v(" Published ")]) : _vm.komment.status === false && _vm.komment.spamlevel === 0 ? _c("k-button", { staticClass: "publish", attrs: { "disabled": _vm.komment.spamlevel > 0, "icon": "circle" }, on: { "click": function($event) {
      return _vm.publish(_vm.komment.slug, _vm.komment.id, true);
    } } }, [_vm._v(" Publish ")]) : _c("k-button", { attrs: { "icon": "protected", "disabled": true } }, [_vm._v(" Publish ")]), _vm.komment.verified === true ? _c("k-button", { attrs: { "theme": "positive", "icon": "check" }, on: { "click": function($event) {
      return _vm.markAsVerified(_vm.komment.slug, _vm.komment.id, false);
    } } }, [_vm._v(" Verified user ")]) : _vm.komment.verified === false && _vm.komment.spamlevel === 0 ? _c("k-button", { attrs: { "icon": "check", "disabled": _vm.komment.spamlevel > 0 }, on: { "click": function($event) {
      return _vm.markAsVerified(_vm.komment.slug, _vm.komment.id, true);
    } } }, [_vm._v(" Verify user ")]) : _c("k-button", { attrs: { "icon": "protected", "disabled": true } }, [_vm._v(" Verify user ")]), _vm.komment.spamlevel === 0 ? _c("k-button", { attrs: { "icon": "bolt" }, on: { "click": function($event) {
      return _vm.markAsSpam(_vm.komment.slug, _vm.komment.id, true);
    } } }, [_vm._v(" Flag as spam ")]) : _vm.komment.spamlevel > 0 ? _c("k-button", { attrs: { "theme": "negative", "icon": "bolt" }, on: { "click": function($event) {
      return _vm.markAsSpam(_vm.komment.slug, _vm.komment.id, false);
    } } }, [_vm._v(" Remove from spam ")]) : _c("k-button", { attrs: { "icon": "clock", "disabled": true } }, [_vm._v(" Marked as spam ")])], 1), _c("div", { staticClass: "right" }, [_c("k-button", { attrs: { "theme": "negative", "icon": "trash" }, on: { "click": function($event) {
      return _vm.$refs.deleteDialog.open();
    } } }, [_vm._v(" Delete ")]), _c("k-dialog", { ref: "deleteDialog", attrs: { "button": "Delete", "theme": "negative", "icon": "trash" }, on: { "submit": function($event) {
      return _vm.deleteKomment(_vm.komment.slug, _vm.komment.id, _vm.$refs);
    } } }, [_c("k-text", [_vm._v(" Do you really want to delete the comment? This cannot be undone. ")])], 1)], 1)]), _c("div", { staticClass: "text", domProps: { "innerHTML": _vm._s(_vm.komment.komment) } })]) : _vm._e()]);
  };
  var _sfc_staticRenderFns$3 = [];
  _sfc_render$3._withStripped = true;
  var __component__$3 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$3,
    _sfc_render$3,
    _sfc_staticRenderFns$3
  );
  __component__$3.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/KommentDetails.vue";
  const KommentDetails = __component__$3.exports;
  const _sfc_main$2 = {
    props: {
      queuedKomments: Array,
      onSelectKomment: Function,
      selectedKomment: Object
    }
  };
  var _sfc_render$2 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "komments-list" }, [_c("ul", _vm._l(_vm.queuedKomments, function(komment, index) {
      return _c("li", { key: index, staticClass: "list-item", class: {
        active: _vm.selectedKomment.id === komment.id,
        isSpam: komment.spamlevel > 0,
        isVerified: komment.verified === true
      }, on: { "click": function($event) {
        return _vm.onSelectKomment(komment.id);
      }, "keypress": function($event) {
        return _vm.onSelectKomment(komment.id);
      } } }, [komment.image ? _c("img", { attrs: { "src": komment.image } }) : _vm._e(), _c("div", { staticClass: "komment-preview" }, [_c("div", { staticClass: "author" }, [_c("strong", [_vm._v(_vm._s(komment.author))])]), _c("div", { staticClass: "meta" }, [_vm._v(_vm._s(komment.published) + " - " + _vm._s(komment.title))]), _c("div", { staticClass: "status" }, [komment.status === false ? _c("span", { staticClass: "badge", attrs: { "alt": "pending", "title": "pending" } }, [_vm._v(" pending ")]) : komment.status === true ? _c("span", { staticClass: "badge blue", attrs: { "alt": "published", "title": "published" } }, [_vm._v(" published ")]) : _vm._e(), komment.verified === true ? _c("span", { staticClass: "badge green", attrs: { "alt": "Verified user", "title": "Verified user" } }, [_vm._v(" verified ")]) : _vm._e(), komment.spamlevel > 0 ? _c("span", { staticClass: "badge red", attrs: { "alt": "Possible spam comment", "title": "Possible spam comment" } }, [_vm._v(" spam ")]) : _vm._e()])])]);
    }), 0)]);
  };
  var _sfc_staticRenderFns$2 = [];
  _sfc_render$2._withStripped = true;
  var __component__$2 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$2,
    _sfc_render$2,
    _sfc_staticRenderFns$2
  );
  __component__$2.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/KommentList.vue";
  const KommentList = __component__$2.exports;
  const _sfc_main$1 = {
    props: {
      queuedComments: Number,
      label: String
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "kommentsPendingCounter" }, [_c("k-headline", [_vm._v(_vm._s(_vm.label))]), _c("div", { staticClass: "count" }, [_vm._v(_vm._s(_vm.queuedComments))])], 1);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1
  );
  __component__$1.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/fields/KommentsPending.vue";
  const KommentsPending = __component__$1.exports;
  const _sfc_main = {
    props: {}
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_c("svg", { attrs: { "data-name": "Layer 1", "xmlns": "http://www.w3.org/2000/svg", "width": "997.86122", "height": "450.8081", "viewBox": "0 0 997.86122 450.8081", "xmlns:xlink": "http://www.w3.org/1999/xlink" } }, [_c("rect", { attrs: { "x": "871.99152", "y": "181.55804", "width": "30.15944", "height": "104.39806", "fill": "#f2f2f2" } }), _c("polygon", { attrs: { "points": "922.068 266.317 848.715 179.052 701.475 180.398 612.156 267.396 613.961 268.556 613.316 268.556 613.316 449.513 921.871 449.513 921.871 268.556 922.068 266.317", "fill": "#f2f2f2" } }), _c("polygon", { attrs: { "points": "848.792 179.238 757.154 286.674 757.154 449.513 921.871 449.513 921.871 266.236 848.792 179.238", "fill": "#e6e6e6" } }), _c("rect", { attrs: { "x": "823.27242", "y": "359.46083", "width": "33.6394", "height": "29.73333", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "823.27242", "y": "307.99568", "width": "33.6394", "height": "29.26181", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "823.27242", "y": "359.46083", "width": "33.6394", "height": "29.73333", "fill": "#fff" } }), _c("rect", { attrs: { "x": "823.27242", "y": "307.99568", "width": "33.6394", "height": "29.26181", "fill": "#fff" } }), _c("rect", { attrs: { "x": "673.77661", "y": "351.57128", "width": "33.6394", "height": "29.73333", "fill": "#fff" } }), _c("rect", { attrs: { "x": "673.77661", "y": "300.10613", "width": "33.6394", "height": "29.26181", "fill": "#fff" } }), _c("rect", { attrs: { "x": "633.99152", "y": "181.55804", "width": "30.15944", "height": "104.39806", "fill": "#f2f2f2" } }), _c("polygon", { attrs: { "points": "684.068 266.317 610.715 179.052 463.475 180.398 374.156 267.396 375.961 268.556 375.316 268.556 375.316 449.513 683.871 449.513 683.871 268.556 684.068 266.317", "fill": "#f2f2f2" } }), _c("polygon", { attrs: { "points": "610.792 179.238 519.154 286.674 519.154 449.513 683.871 449.513 683.871 266.236 610.792 179.238", "fill": "#e6e6e6" } }), _c("rect", { attrs: { "x": "585.27242", "y": "359.46083", "width": "33.6394", "height": "29.73333", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "585.27242", "y": "307.99568", "width": "33.6394", "height": "29.26181", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "585.27242", "y": "359.46083", "width": "33.6394", "height": "29.73333", "fill": "#fff" } }), _c("rect", { attrs: { "x": "585.27242", "y": "307.99568", "width": "33.6394", "height": "29.26181", "fill": "#fff" } }), _c("rect", { attrs: { "x": "435.77661", "y": "351.57128", "width": "33.6394", "height": "29.73333", "fill": "#fff" } }), _c("rect", { attrs: { "x": "435.77661", "y": "300.10613", "width": "33.6394", "height": "29.26181", "fill": "#fff" } }), _c("rect", { attrs: { "x": "380.1536", "y": "91.46021", "width": "40.30032", "height": "139.50112", "fill": "#f2f2f2" } }), _c("polygon", { attrs: { "points": "447.068 204.718 349.051 88.112 152.302 89.91 32.951 206.161 35.362 207.711 34.501 207.711 34.501 449.513 446.804 449.513 446.804 207.711 447.068 204.718", "fill": "#f2f2f2" } }), _c("polygon", { attrs: { "points": "349.153 88.36 226.702 231.921 226.702 449.513 446.804 449.513 446.804 204.611 349.153 88.36", "fill": "#e6e6e6" } }), _c("rect", { attrs: { "x": "315.05306", "y": "329.18147", "width": "44.95039", "height": "39.73094", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "315.05306", "y": "260.41156", "width": "44.95039", "height": "39.10088", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "315.05306", "y": "329.18147", "width": "44.95039", "height": "39.73094", "fill": "#fff" } }), _c("rect", { attrs: { "x": "315.05306", "y": "260.41156", "width": "44.95039", "height": "39.10088", "fill": "#fff" } }), _c("rect", { attrs: { "x": "115.29041", "y": "318.63912", "width": "44.95039", "height": "39.73094", "fill": "#fff" } }), _c("rect", { attrs: { "x": "115.29041", "y": "249.8692", "width": "44.95039", "height": "39.10088", "fill": "#fff" } }), _c("rect", { attrs: { "y": "448.61997", "width": "963.95079", "height": "2", "fill": "#3f3d56" } }), _c("ellipse", { attrs: { "cx": "151.87223", "cy": "352.47204", "rx": "29.09932", "ry": "59.37437", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M255.62882,674.25425c-11.65458-69.92526-.11734-139.59789.00056-140.29293l2.267.384c-.11734.69167-11.58834,69.99825.00056,139.53164Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#a8a8bf" } }), _c("rect", { attrs: { "x": "251.0257", "y": "571.20214", "width": "29.84136", "height": "2.29972", "transform": "translate(-339.58156 -31.50095) rotate(-28.1416)", "fill": "#a8a8bf" } }), _c("rect", { attrs: { "x": "237.02319", "y": "564.48509", "width": "2.29972", "height": "29.84239", "transform": "translate(-486.12468 291.37147) rotate(-61.84204)", "fill": "#a8a8bf" } }), _c("ellipse", { attrs: { "cx": "81.9552", "cy": "260.90342", "rx": "56.91484", "ry": "116.12927", "fill": "#a8a8bf" } }), _c("path", { attrs: { "d": "M189.364,675.40405c-22.76459-136.58529-.22963-272.67316.00056-274.03181l2.267.384c-.22962,1.35528-22.69834,137.0771.00057,273.27052Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "179.27648", "y": "475.12522", "width": "58.36761", "height": "2.29972", "transform": "translate(-301.0624 -69.97216) rotate(-28.1416)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "152.98936", "y": "460.88882", "width": "2.29972", "height": "58.36761", "transform": "translate(-451.74248 170.111) rotate(-61.84258)", "fill": "#3f3d56" } }), _c("ellipse", { attrs: { "cx": "216.75351", "cy": "191.008", "rx": "77.88347", "ry": "158.91374", "fill": "#a8a8bf" } }), _c("path", { attrs: { "d": "M326.9161,675.40405c-31.1399-186.83717-.3144-372.9922.00056-374.85051l2.267.384c-.3144,1.85494-31.07366,187.64393.00056,374.08922Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "312.69421", "y": "401.83114", "width": "79.87126", "height": "2.29972", "transform": "translate(-249.45002 -10.63875) rotate(-28.1416)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "277.14586", "y": "381.92603", "width": "2.29972", "height": "79.87126", "transform": "translate(-326.03583 243.55793) rotate(-61.84329)", "fill": "#3f3d56" } }), _c("ellipse", { attrs: { "cx": "871.02934", "cy": "352.47204", "rx": "29.09932", "ry": "59.37437", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M969.41153,674.25425c11.65459-69.92526.11734-139.59789-.00056-140.29293l-2.267.384c.11733.69167,11.58833,69.99825-.00056,139.53164Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#a8a8bf" } }), _c("rect", { attrs: { "x": "957.94412", "y": "557.43132", "width": "2.29972", "height": "29.84136", "transform": "translate(-99.02545 923.51928) rotate(-61.8584)", "fill": "#a8a8bf" } }), _c("rect", { attrs: { "x": "971.94611", "y": "578.25643", "width": "29.84239", "height": "2.29972", "transform": "translate(-257.69773 309.6834) rotate(-28.15796)", "fill": "#a8a8bf" } }), _c("ellipse", { attrs: { "cx": "940.94638", "cy": "260.90342", "rx": "56.91484", "ry": "116.12927", "fill": "#a8a8bf" } }), _c("path", { attrs: { "d": "M1035.67632,675.40405c22.76459-136.58529.22962-272.67316-.00056-274.03181l-2.267.384c.22962,1.35528,22.69834,137.0771-.00056,273.27052Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "1015.43021", "y": "447.09128", "width": "2.29972", "height": "58.36761", "transform": "translate(16.06635 923.44761) rotate(-61.8584)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "1041.71733", "y": "488.92276", "width": "58.36761", "height": "2.29972", "transform": "translate(-205.59609 338.75568) rotate(-28.15742)", "fill": "#3f3d56" } }), _c("ellipse", { attrs: { "cx": "806.14806", "cy": "191.008", "rx": "77.88347", "ry": "158.91374", "fill": "#a8a8bf" } }), _c("path", { attrs: { "d": "M898.12426,675.40405c31.1399-186.83717.31439-372.9922-.00056-374.85051l-2.267.384c.3144,1.85494,31.07365,187.64393-.00056,374.08922Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "871.26065", "y": "363.04537", "width": "2.29972", "height": "79.87126", "transform": "translate(4.52428 757.59634) rotate(-61.8584)", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "906.809", "y": "420.7118", "width": "79.87126", "height": "2.29972", "transform": "translate(-188.10195 272.08136) rotate(-28.15671)", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M690.67376,326.06186l9.20569-7.3628c-7.15149-.789-10.0899,3.11127-11.29248,6.19837-5.587-2.32-11.66919.72046-11.66919.72046l18.41889,6.6867A13.93792,13.93792,0,0,0,690.67376,326.06186Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M465.67376,261.06186l9.20569-7.3628c-7.15149-.789-10.0899,3.11127-11.29248,6.19837-5.587-2.32-11.66919.72046-11.66919.72046l18.41889,6.6867A13.93792,13.93792,0,0,0,465.67376,261.06186Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M832.67376,232.06186l9.20569-7.3628c-7.15149-.789-10.0899,3.11127-11.29248,6.19837-5.587-2.32-11.66919.72046-11.66919.72046l18.41889,6.6867A13.93792,13.93792,0,0,0,832.67376,232.06186Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M851.26034,661.648a13.91772,13.91772,0,0,0-6.96955,1.86975A14.98175,14.98175,0,0,0,819.26034,674.648h45.94952A13.99045,13.99045,0,0,0,851.26034,661.648Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M384.26034,661.648a13.91772,13.91772,0,0,0-6.96955,1.86975A14.98175,14.98175,0,0,0,352.26034,674.648h45.94952A13.99045,13.99045,0,0,0,384.26034,661.648Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("path", { attrs: { "d": "M623.26034,661.648a13.91772,13.91772,0,0,0-6.96955,1.86975A14.98175,14.98175,0,0,0,591.26034,674.648h45.94952A13.99045,13.99045,0,0,0,623.26034,661.648Z", "transform": "translate(-101.06939 -224.59595)", "fill": "#3f3d56" } }), _c("polygon", { attrs: { "points": "471.759 404.228 339.191 404.228 339.191 408.504 359.866 408.504 359.866 449.13 364.142 449.13 364.142 408.504 444.669 408.504 444.669 449.13 448.946 449.13 448.946 408.504 471.759 408.504 471.759 404.228", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "339.45191", "y": "391.43404", "width": "132.56808", "height": "4.27639", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "339.45191", "y": "380.74306", "width": "132.56808", "height": "4.27639", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "339.45191", "y": "370.05209", "width": "132.56808", "height": "4.27639", "fill": "#3f3d56" } }), _c("polygon", { attrs: { "points": "678.759 404.228 546.191 404.228 546.191 408.504 566.866 408.504 566.866 449.13 571.142 449.13 571.142 408.504 651.669 408.504 651.669 449.13 655.946 449.13 655.946 408.504 678.759 408.504 678.759 404.228", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "546.45191", "y": "391.43404", "width": "132.56808", "height": "4.27639", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "546.45191", "y": "380.74306", "width": "132.56808", "height": "4.27639", "fill": "#3f3d56" } }), _c("rect", { attrs: { "x": "546.45191", "y": "370.05209", "width": "132.56808", "height": "4.27639", "fill": "#3f3d56" } })])]);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns
  );
  __component__.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/NoKomments.vue";
  const NoKomments = __component__.exports;
  panel.plugin("mauricerenck/komments", {
    components: {
      "k-komments-view": View,
      KommentDetails,
      KommentList,
      NoKomments,
      CommentContent,
      "komments-detail-drawer": DrawerDetails,
      "komments-reply-drawer": DrawerReply
    },
    fields: {
      // komments: KommentsView,
      kommentsPending: KommentsPending
    }
  });
})();
