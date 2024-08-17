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
  const _sfc_main$8 = {
    props: {
      queuedKomments: Object,
      affectedPages: Array
    }
  };
  var _sfc_render$8 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-inside", [_c("div", { staticClass: "k-komments-view" }, [_c("k-headline", { attrs: { "tag": "h2" } }, [_vm._v("Comments")]), _c("CommentsTable", { attrs: { "comments": this.queuedKomments, "affectedPages": this.affectedPages } })], 1)]);
  };
  var _sfc_staticRenderFns$8 = [];
  _sfc_render$8._withStripped = true;
  var __component__$8 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$8,
    _sfc_render$8,
    _sfc_staticRenderFns$8
  );
  __component__$8.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/View.vue";
  const View = __component__$8.exports;
  const _sfc_main$7 = {
    mixins: ["drawer"],
    props: {
      comment: {
        type: Object,
        default: {}
      }
    }
  };
  var _sfc_render$7 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-drawer", _vm._b({}, "k-drawer", _vm.$props, false), [_c("CommentContent", { attrs: { "spamlevel": _vm.comment.spamlevel, "content": _vm.comment.content } }), _c("div", { staticClass: "k-table" }, [_c("table", { staticStyle: { "table-layout": "auto" } }, [_c("tbody", [_c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Id")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.id))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Type")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.type))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Language")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.language))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Published")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.published))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Verified")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.verified))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Reply To")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.parentid))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Spam level")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.spamlevel))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Upvotes")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.upvotes))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Downvotes")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.downvotes))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Created at")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.createdat))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Updated at")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.updatedat))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Permalink")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.permalink))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Author")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorname))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Avatar")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authoravatar))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Email")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authoremail))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Url")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorurl))])])])])])], 1);
  };
  var _sfc_staticRenderFns$7 = [];
  _sfc_render$7._withStripped = true;
  var __component__$7 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$7,
    _sfc_render$7,
    _sfc_staticRenderFns$7
  );
  __component__$7.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/DrawerDetails.vue";
  const DrawerDetails = __component__$7.exports;
  const _sfc_main$6 = {
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
  var _sfc_render$6 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-drawer", _vm._b({}, "k-drawer", _vm.$props, false), [!this.originPublished ? _c("k-box", { key: "unpublished", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "notice", "text": "This comment is not published yet. When you reply, it will be published along with your reply." } }) : _vm._e(), this.replyCreated ? _c("k-box", { key: "created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "positive", "text": "Your reply has been published." } }) : this.replyCreated === false ? _c("k-box", { key: "not-created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "negative", "text": "Your reply could not be published. Please try again." } }) : _vm._e(), _c("CommentContent", { attrs: { "spamlevel": _vm.comment.spamlevel, "content": _vm.comment.content } }), _c("k-writer-field", { staticStyle: { "margin-bottom": "var(--spacing-1)" }, attrs: { "autofocus": true, "label": `Reply to ${_vm.comment.authorname}`, "value": _vm.content }, on: { "input": function($event) {
      _vm.content = $event;
    } } }), _c("k-button", { key: "green", attrs: { "theme": "green", "variant": "filled", "icon": _vm.isSending ? _vm.loader : null, "disabled": _vm.isSending }, on: { "click": this.sendReply } }, [_vm._v(" Send reply ")])], 1);
  };
  var _sfc_staticRenderFns$6 = [];
  _sfc_render$6._withStripped = true;
  var __component__$6 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$6,
    _sfc_render$6,
    _sfc_staticRenderFns$6
  );
  __component__$6.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/DrawerReply.vue";
  const DrawerReply = __component__$6.exports;
  const _sfc_main$5 = {
    props: {
      spamlevel: Number,
      content: String
    }
  };
  var _sfc_render$5 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_vm.spamlevel > 0 ? _c("k-box", { key: "spam", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "warning", "text": "This comment is marked as spam. Its content is shown as plain text to prevent accidental exposure to harmful content." } }) : _vm._e(), _c("k-box", { staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "text" } }, [_vm.spamlevel === 0 ? _c("k-text", { domProps: { "innerHTML": _vm._s(_vm.content) } }) : _c("k-text", [_vm._v(_vm._s(_vm.content))])], 1)], 1);
  };
  var _sfc_staticRenderFns$5 = [];
  _sfc_render$5._withStripped = true;
  var __component__$5 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$5,
    _sfc_render$5,
    _sfc_staticRenderFns$5
  );
  __component__$5.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/CommentContent.vue";
  const CommentContent = __component__$5.exports;
  const _sfc_main$4 = {
    props: {
      comments: Object,
      affectedPages: Array,
      columns: Array
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
      visibleColumns() {
        const availableColumns = [
          "author",
          "content",
          "pageTitle",
          "updatedAt",
          "spamlevel",
          "verified",
          "published",
          "type"
        ];
        const visibleColumns = this.columns || availableColumns;
        const filteredColumns = [...visibleColumns].filter((column) => availableColumns.includes(column));
        const columnConfigs = {
          author: { label: "Author", type: "html" },
          content: { label: "Comment", type: "text" },
          pageTitle: { label: "Page", type: "html" },
          updatedAt: { label: "Last Update", type: "html" },
          spamlevel: { label: "Spamlevel", type: "html", width: "40px", align: "center" },
          verified: { label: "Verified", type: "html", width: "40px", align: "center" },
          published: { label: "Published", type: "html", width: "40px", align: "center" },
          type: { label: "Type", type: "html", width: "40px", align: "center" }
        };
        return Object.fromEntries(filteredColumns.map((column) => [column, columnConfigs[column]]));
      },
      commentList() {
        const typeIcons = {
          comment: "chat",
          "in-reply-to": "megaphone",
          "repost-of": "indie-repost",
          "mention-of": "indie-mention",
          "like-of": "heart",
          "bookmark-of": "bookmark",
          rsvp: "calendar",
          invite: "calendar"
        };
        const actionTypes = {
          "in-reply-to": "Webmention reply",
          "repost-of": "Webmention repost",
          "mention-of": "Webmention mention",
          "like-of": "Webmention like",
          "bookmark-of": "Webmention bookmark",
          rsvp: "Webmention RSVP",
          invite: "Webmention invite"
        };
        const commentList = [];
        this.pagination.total = 0;
        this.comments.forEach((comment) => {
          const pageOfComment = this.affectedPages.find((page) => page.uuid === comment.pageuuid);
          const content = comment.content ? comment.content.replace(/<[^>]*>/g, "") : `(${actionTypes[comment.type]})`;
          const newComment = {
            id: comment.id,
            pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
            author: `<span class="author-entry"><img src="${comment.authoravatar}" width="30px" height="30px" />${comment.authorname}</span>`,
            content,
            updatedAt: comment.updatedat,
            type: `<span title="${comment.type}"><svg aria-hidden="true" data-type="${typeIcons[comment.type]}" class="k-icon" style="color: var(--color-blue-700);"><use xlink:href="#icon-${typeIcons[comment.type]}"></use></svg></span>`,
            spamlevel: comment.spamlevel > 0 ? '<svg aria-hidden="true" data-type="flag" class="k-icon" style="color: var(--color-red-700);"><use xlink:href="#icon-flag"></use></svg>' : "",
            verified: comment.verified ? '<svg aria-hidden="true" data-type="sparkling" class="k-icon" style="color: var(--color-yellow-700);"><use xlink:href="#icon-sparkling"></use></svg>' : "",
            published: comment.published ? '<svg aria-hidden="true" data-type="preview" class="k-icon" style="color: var(--color-green-700);"><use xlink:href="#icon-preview"></use></svg>' : '<svg aria-hidden="true" data-type="hidden" class="k-icon" style="color: var(--color-red-700);"><use xlink:href="#icon-hidden"></use></svg>'
          };
          commentList.push(newComment);
          this.pagination.total++;
        });
        return commentList.slice(this.index - 1, this.pagination.limit * this.pagination.page);
      }
    },
    methods: {
      showCommentDetails(id) {
        const comment = this.comments.find((comment2) => comment2.id === id);
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
        const comment = this.comments.find((comment2) => comment2.id === id);
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
          this.comments.find((item) => item.id === id).published = response.published;
        });
      },
      deleteComment(id) {
        panel.dialog.open(`comment/delete/${id}`);
      },
      flagComment(id, type) {
        panel.api.post(`komments/flag/${id}/${type}`).then((response) => {
          this.comments.find((item) => item.id === id)[type] = response[type];
        });
      },
      dropdownOptions(row) {
        const comment = this.comments.find((item) => item.id === row.id);
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
  var _sfc_render$4 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-komments-view" }, [_c("k-table", { attrs: { "columns": this.visibleColumns, "index": true, "rows": this.commentList, "pagination": { page: _vm.pagination.page, limit: _vm.pagination.limit, total: _vm.pagination.total, details: true } }, on: { "paginate": function($event) {
      _vm.pagination.page = $event.page;
    } }, scopedSlots: _vm._u([{ key: "header", fn: function({ columnIndex, label }) {
      return [_c("span", { attrs: { "title": label } }, [columnIndex === "verified" ? _c("k-icon", { staticStyle: { "color": "var(--color-yellow-700)" }, attrs: { "type": "sparkling" } }) : columnIndex === "spamlevel" ? _c("k-icon", { staticStyle: { "color": "var(--color-red-700)" }, attrs: { "type": "flag" } }) : columnIndex === "published" ? _c("k-icon", { staticStyle: { "color": "var(--color-green-700)" }, attrs: { "type": "preview" } }) : columnIndex === "type" ? _c("k-icon", { staticStyle: { "color": "var(--color-blue-700)" }, attrs: { "type": "box" } }) : _c("span", [_vm._v(_vm._s(label))])], 1)];
    } }, { key: "options", fn: function({ row }) {
      return [_c("k-options-dropdown", { attrs: { "options": _vm.dropdownOptions(row) } })];
    } }]) })], 1);
  };
  var _sfc_staticRenderFns$4 = [];
  _sfc_render$4._withStripped = true;
  var __component__$4 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$4,
    _sfc_render$4,
    _sfc_staticRenderFns$4
  );
  __component__$4.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/fields/CommentsTable.vue";
  const CommentsTable = __component__$4.exports;
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
      CommentsTable,
      "komments-detail-drawer": DrawerDetails,
      "komments-reply-drawer": DrawerReply
    },
    fields: {
      // komments: KommentsView,
      kommentsPending: KommentsPending,
      CommentsTable
    },
    icons: {
      "shape-icon-bookmark": '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" data-reactroot=""><path fill = "#293449" d = "M18 22L12 16L6 22V3C6 2.45 6.45 2 7 2H17C17.55 2 18 2.45 18 3V22Z"></path></svg>',
      "shape-icon-fav": '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" data-reactroot=""><path fill="#293449" d="M3.29289 3.29289C3.68342 2.90237 4.31658 2.90237 4.70711 3.29289L6.70711 5.29289C7.09763 5.68342 7.09763 6.31658 6.70711 6.70711C6.31658 7.09763 5.68342 7.09763 5.29289 6.70711L3.29289 4.70711C2.90237 4.31658 2.90237 3.68342 3.29289 3.29289Z" clip-rule="evenodd" fill-rule="evenodd"></path><path fill="#293449" d="M20.7071 3.29289C21.0976 3.68342 21.0976 4.31658 20.7071 4.70711L18.7071 6.70711C18.3166 7.09763 17.6834 7.09763 17.2929 6.70711C16.9024 6.31658 16.9024 5.68342 17.2929 5.29289L19.2929 3.29289C19.6834 2.90237 20.3166 2.90237 20.7071 3.29289Z" clip-rule="evenodd" fill-rule="evenodd" ></path><path fill="#293449" d="M12 2L15 9H22L17 15L19 22L12 18L5 22L7 15L2 9H9L12 2Z"></path><path fill="#293449" d="M19.7056 16.3528C19.9526 15.8588 20.5533 15.6586 21.0473 15.9056L22.4473 16.6056C22.9413 16.8526 23.1415 17.4533 22.8945 17.9472C22.6475 18.4412 22.0468 18.6414 21.5529 18.3945L20.1529 17.6945C19.6589 17.4475 19.4587 16.8468 19.7056 16.3528Z" clip-rule="evenodd" fill-rule="evenodd"></path><path fill="#293449" d="M4.2944 16.3528C4.54139 16.8468 4.34117 17.4475 3.84719 17.6945L2.44719 18.3945C1.95321 18.6414 1.35254 18.4412 1.10555 17.9472C0.858558 17.4533 1.05878 16.8526 1.55276 16.6056L2.95276 15.9056C3.44674 15.6586 4.04741 15.8588 4.2944 16.3528Z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>',
      "shape-icon-mention": '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" data-reactroot=""><path fill="#293449" d="M12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9ZM7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12Z" clip-rule="evenodd" fill-rule="evenodd" ></path><path fill="#293449" d="M20.9818 11.4403C20.6939 6.75101 16.6454 2.97295 11.9558 2.9999C10.3701 3.00891 8.89626 3.4225 7.60028 4.15149L7.59817 4.15267C4.4127 5.93438 2.43215 9.60364 3.14475 13.6458C3.80937 17.3894 6.89858 20.3711 10.6618 20.91C12.4448 21.1632 14.1248 20.9 15.5934 20.2463C16.0979 20.0217 16.689 20.2487 16.9136 20.7533C17.1382 21.2578 16.9112 21.8489 16.4067 22.0735C14.5956 22.8797 12.5359 23.1965 10.3793 22.89L10.3783 22.8898C5.76167 22.2287 1.99102 18.5908 1.1754 13.9946L1.17522 13.9936C0.308115 9.07635 2.72704 4.58616 6.62087 2.40772C8.20461 1.5171 10.0104 1.01093 11.9443 0.999932M20.9818 11.4403C21.0175 12.0488 20.9913 12.6539 20.9187 13.2478C20.7765 14.2196 19.9203 14.9499 18.93 14.9499H18.8117C17.8017 14.902 17 14.0617 17 13.0399V7.99992C17 7.44763 16.5523 6.99992 16 6.99992C15.4477 6.99992 15 7.44763 15 7.99992V13.0399C15 15.1323 16.6497 16.8683 18.7516 16.9492C18.7644 16.9497 18.7772 16.9499 18.79 16.9499H18.93C20.8969 16.9499 22.6186 15.5044 22.9001 13.5204L22.9025 13.5021C22.989 12.7997 23.0223 12.0688 22.9783 11.3212L22.9781 11.3187C22.6256 5.56842 17.6944 0.966921 11.9443 0.999932" clip-rule="evenodd" fill-rule="evenodd"></path></svg>',
      "shape-icon-reply": '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" data-reactroot=""><path fill="#293449" d="M22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C13.8 22 15.5 21.5 17 20.6L22 22L20.7 17C21.5 15.5 22 13.8 22 12Z"></path><path stroke-linecap="round" stroke-miterlimit="10" stroke-width="1" stroke="white" d="M16.9951 12H17.0051"></path><path stroke-linecap="round" stroke-miterlimit="10" stroke-width="1" stroke="white" d="M11.9951 12H12.0051"></path><path stroke-linecap="round" stroke-miterlimit="10" stroke-width="1" stroke="white" d="M6.99512 12H7.00512"></path><path stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1" stroke="white" d="M17 12.5C17.2761 12.5 17.5 12.2761 17.5 12C17.5 11.7239 17.2761 11.5 17 11.5C16.7239 11.5 16.5 11.7239 16.5 12C16.5 12.2761 16.7239 12.5 17 12.5Z"></path><path stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1" stroke="white" d="M12 12.5C12.2761 12.5 12.5 12.2761 12.5 12C12.5 11.7239 12.2761 11.5 12 11.5C11.7239 11.5 11.5 11.7239 11.5 12C11.5 12.2761 11.7239 12.5 12 12.5Z"></path><path stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1" stroke="white" d="M7 12.5C7.27614 12.5 7.5 12.2761 7.5 12C7.5 11.7239 7.27614 11.5 7 11.5C6.72386 11.5 6.5 11.7239 6.5 12C6.5 12.2761 6.72386 12.5 7 12.5Z"></path></svg>',
      "shape-icon-repost": '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" data-reactroot=""><path fill="#293449" d="M5 10C3.85228 10 3 10.8523 3 12C3 13.1477 3.85228 14 5 14H6C6.55228 14 7 14.4477 7 15C7 15.5523 6.55228 16 6 16H5C2.74772 16 1 14.2523 1 12C1 9.74772 2.74772 8 5 8H12C12.5523 8 13 8.44772 13 9C13 9.55228 12.5523 10 12 10H5Z" clip-rule="evenodd" fill-rule="evenodd"></path><path fill="#293449" d="M8.99998 5.9458V12.0543L13.8868 9.00005L8.99998 5.9458Z" clip-rule="evenodd" fill-rule="evenodd"></path><path fill="#293449" d="M17 9C17 8.44772 17.4477 8 18 8H19C21.2523 8 23 9.74772 23 12C23 14.2523 21.2523 16 19 16H12C11.4477 16 11 15.5523 11 15C11 14.4477 11.4477 14 12 14H19C20.1477 14 21 13.1477 21 12C21 10.8523 20.1477 10 19 10H18C17.4477 10 17 9.55228 17 9Z" clip-rule="evenodd" fill-rule="evenodd"></path><path fill="#293449" d="M15 18.0542L15 11.9457L10.1132 15L15 18.0542Z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>',
      "indie-mastodon": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.2595 13.9898C20.9852 15.4006 18.8033 16.9446 16.2974 17.2439C14.9907 17.3998 13.7041 17.5431 12.3321 17.4802C10.0885 17.3774 8.31809 16.9446 8.31809 16.9446C8.31809 17.163 8.33156 17.371 8.3585 17.5655C8.65019 19.7797 10.5541 19.9124 12.3576 19.9742C14.1779 20.0365 15.7987 19.5254 15.7987 19.5254L15.8735 21.1711C15.8735 21.1711 14.6003 21.8548 12.3321 21.9805C11.0814 22.0493 9.52849 21.9491 7.71973 21.4703C3.79684 20.432 3.12219 16.2504 3.01896 12.0074C2.98749 10.7477 3.00689 9.55981 3.00689 8.56632C3.00689 4.22771 5.84955 2.95599 5.84955 2.95599C7.2829 2.29772 9.74238 2.0209 12.2993 2H12.3621C14.919 2.0209 17.3801 2.29772 18.8133 2.95599C18.8133 2.95599 21.6559 4.22771 21.6559 8.56632C21.6559 8.56632 21.6916 11.7674 21.2595 13.9898ZM18.3029 8.9029C18.3029 7.82924 18.0295 6.97604 17.4805 6.34482C16.9142 5.71359 16.1726 5.39001 15.2522 5.39001C14.187 5.39001 13.3805 5.79937 12.8473 6.61819L12.3288 7.48723L11.8104 6.61819C11.2771 5.79937 10.4706 5.39001 9.40554 5.39001C8.485 5.39001 7.74344 5.71359 7.17719 6.34482C6.62807 6.97604 6.3547 7.82924 6.3547 8.9029V14.1562H8.43597V9.05731C8.43597 7.98246 8.88822 7.4369 9.79281 7.4369C10.793 7.4369 11.2944 8.08408 11.2944 9.36376V12.1547H13.3634V9.36376C13.3634 8.08408 13.8646 7.4369 14.8648 7.4369C15.7694 7.4369 16.2216 7.98246 16.2216 9.05731V14.1562H18.3029V8.9029Z"></path></svg>',
      "indie-twitter": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M22.2125 5.65605C21.4491 5.99375 20.6395 6.21555 19.8106 6.31411C20.6839 5.79132 21.3374 4.9689 21.6493 4.00005C20.8287 4.48761 19.9305 4.83077 18.9938 5.01461C18.2031 4.17106 17.098 3.69303 15.9418 3.69434C13.6326 3.69434 11.7597 5.56661 11.7597 7.87683C11.7597 8.20458 11.7973 8.52242 11.8676 8.82909C8.39047 8.65404 5.31007 6.99005 3.24678 4.45941C2.87529 5.09767 2.68005 5.82318 2.68104 6.56167C2.68104 8.01259 3.4196 9.29324 4.54149 10.043C3.87737 10.022 3.22788 9.84264 2.64718 9.51973C2.64654 9.5373 2.64654 9.55487 2.64654 9.57148C2.64654 11.5984 4.08819 13.2892 6.00199 13.6731C5.6428 13.7703 5.27232 13.8194 4.90022 13.8191C4.62997 13.8191 4.36771 13.7942 4.11279 13.7453C4.64531 15.4065 6.18886 16.6159 8.0196 16.6491C6.53813 17.8118 4.70869 18.4426 2.82543 18.4399C2.49212 18.4402 2.15909 18.4205 1.82812 18.3811C3.74004 19.6102 5.96552 20.2625 8.23842 20.2601C15.9316 20.2601 20.138 13.8875 20.138 8.36111C20.138 8.1803 20.1336 7.99886 20.1256 7.81997C20.9443 7.22845 21.651 6.49567 22.2125 5.65605Z"></path></svg>',
      "indie-website": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM9.71002 19.6674C8.74743 17.6259 8.15732 15.3742 8.02731 13H4.06189C4.458 16.1765 6.71639 18.7747 9.71002 19.6674ZM10.0307 13C10.1811 15.4388 10.8778 17.7297 12 19.752C13.1222 17.7297 13.8189 15.4388 13.9693 13H10.0307ZM19.9381 13H15.9727C15.8427 15.3742 15.2526 17.6259 14.29 19.6674C17.2836 18.7747 19.542 16.1765 19.9381 13ZM4.06189 11H8.02731C8.15732 8.62577 8.74743 6.37407 9.71002 4.33256C6.71639 5.22533 4.458 7.8235 4.06189 11ZM10.0307 11H13.9693C13.8189 8.56122 13.1222 6.27025 12 4.24799C10.8778 6.27025 10.1811 8.56122 10.0307 11ZM14.29 4.33256C15.2526 6.37407 15.8427 8.62577 15.9727 11H19.9381C19.542 7.8235 17.2836 5.22533 14.29 4.33256Z"></path></svg>',
      "indie-mention": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C13.6418 20 15.1681 19.5054 16.4381 18.6571L17.5476 20.3214C15.9602 21.3818 14.0523 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V13.5C22 15.433 20.433 17 18.5 17C17.2958 17 16.2336 16.3918 15.6038 15.4659C14.6942 16.4115 13.4158 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C13.1258 7 14.1647 7.37209 15.0005 8H17V13.5C17 14.3284 17.6716 15 18.5 15C19.3284 15 20 14.3284 20 13.5V12ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"></path></svg>',
      "indie-repost": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4H21C21.5523 4 22 4.44772 22 5V12H20V6H6V9L1 5L6 1V4ZM18 20H3C2.44772 20 2 19.5523 2 19V12H4V18H18V15L23 19L18 23V20Z"></path></svg>',
      "indie-sent": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4.99989 13.9999L4.99976 5L6.99976 4.99997L6.99986 11.9999L17.1717 12L13.222 8.05024L14.6362 6.63603L21.0001 13L14.6362 19.364L13.222 17.9497L17.1717 14L4.99989 13.9999Z"></path></svg>'
    }
  });
})();
