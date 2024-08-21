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
  const _sfc_main$5 = {
    props: {
      queuedKomments: Object,
      affectedPages: Array,
      webmentions: Boolean
    }
  };
  var _sfc_render$5 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-inside", [_c("div", { staticClass: "k-komments-view" }, [_c("k-headline", { attrs: { "tag": "h2" } }, [_vm._v("Comments")]), _c("CommentsTable", { attrs: { "comments": this.queuedKomments, "affectedPages": this.affectedPages, "webmentions": this.webmentions } })], 1)]);
  };
  var _sfc_staticRenderFns$5 = [];
  _sfc_render$5._withStripped = true;
  var __component__$5 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$5,
    _sfc_render$5,
    _sfc_staticRenderFns$5
  );
  __component__$5.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/View.vue";
  const View = __component__$5.exports;
  const _sfc_main$4 = {
    mixins: ["drawer"],
    props: {
      comment: {
        type: Object,
        default: {}
      }
    }
  };
  var _sfc_render$4 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-drawer", _vm._b({}, "k-drawer", _vm.$props, false), [_c("CommentContent", { attrs: { "spamlevel": _vm.comment.spamlevel, "content": _vm.comment.content } }), _c("div", { staticClass: "k-table" }, [_c("table", { staticStyle: { "table-layout": "auto" } }, [_c("tbody", [_c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Id")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.id))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Type")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.type))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Language")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.language))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Published")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.published))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Verified")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.verified))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Reply To")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.parentid))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Spam level")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.spamlevel))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Upvotes")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.upvotes))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Downvotes")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.downvotes))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Created at")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.createdat))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Updated at")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.updatedat))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Permalink")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.permalink))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Author")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorname))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Avatar")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authoravatar))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Email")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authoremail))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Url")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorurl))])])])])])], 1);
  };
  var _sfc_staticRenderFns$4 = [];
  _sfc_render$4._withStripped = true;
  var __component__$4 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$4,
    _sfc_render$4,
    _sfc_staticRenderFns$4
  );
  __component__$4.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/DrawerDetails.vue";
  const DrawerDetails = __component__$4.exports;
  const _sfc_main$3 = {
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
  var _sfc_render$3 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-drawer", _vm._b({}, "k-drawer", _vm.$props, false), [!this.originPublished ? _c("k-box", { key: "unpublished", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "notice", "text": "This comment is not published yet. When you reply, it will be published along with your reply." } }) : _vm._e(), this.replyCreated ? _c("k-box", { key: "created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "positive", "text": "Your reply has been published." } }) : this.replyCreated === false ? _c("k-box", { key: "not-created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "negative", "text": "Your reply could not be published. Please try again." } }) : _vm._e(), _c("CommentContent", { attrs: { "spamlevel": _vm.comment.spamlevel, "content": _vm.comment.content } }), _c("k-writer-field", { staticStyle: { "margin-bottom": "var(--spacing-1)" }, attrs: { "autofocus": true, "label": `Reply to ${_vm.comment.authorname}`, "value": _vm.content }, on: { "input": function($event) {
      _vm.content = $event;
    } } }), _c("k-button", { key: "green", attrs: { "theme": "green", "variant": "filled", "icon": _vm.isSending ? _vm.loader : null, "disabled": _vm.isSending }, on: { "click": this.sendReply } }, [_vm._v(" Send reply ")])], 1);
  };
  var _sfc_staticRenderFns$3 = [];
  _sfc_render$3._withStripped = true;
  var __component__$3 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$3,
    _sfc_render$3,
    _sfc_staticRenderFns$3
  );
  __component__$3.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/DrawerReply.vue";
  const DrawerReply = __component__$3.exports;
  const _sfc_main$2 = {
    props: {
      icon: String,
      color: String
    }
  };
  var _sfc_render$2 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("svg", { staticClass: "k-icon", style: `color: var(${this.color})`, attrs: { "aria-hidden": "true", "data-type": this.icon } }, [_c("use", { attrs: { "xlink:href": `#icon-${this.icon}` } })]);
  };
  var _sfc_staticRenderFns$2 = [];
  _sfc_render$2._withStripped = true;
  var __component__$2 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$2,
    _sfc_render$2,
    _sfc_staticRenderFns$2
  );
  __component__$2.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/TableIcon.vue";
  const TableIcon = __component__$2.exports;
  const _sfc_main$1 = {
    props: {
      spamlevel: Number,
      content: String
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_vm.spamlevel > 0 ? _c("k-box", { key: "spam", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "warning", "text": "This comment is marked as spam. Its content is shown as plain text to prevent accidental exposure to harmful content." } }) : _vm._e(), _c("k-box", { staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "text" } }, [_vm.spamlevel === 0 ? _c("k-text", { domProps: { "innerHTML": _vm._s(_vm.content) } }) : _c("k-text", [_vm._v(_vm._s(_vm.content))])], 1)], 1);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1
  );
  __component__$1.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/fields/CommentContent.vue";
  const CommentContent = __component__$1.exports;
  const _sfc_main = {
    props: {
      comments: Object,
      affectedPages: Array,
      columns: Array,
      webmentions: Boolean
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
        const comments = this.webmentions ? this.comments : this.comments.filter((comment) => comment.type === "comment");
        comments.forEach((comment) => {
          const pageOfComment = this.affectedPages.find((page) => page.uuid === comment.pageuuid);
          const content = comment.content ? comment.content.replace(/<[^>]*>/g, "") : `(${actionTypes[comment.type]})`;
          const publishDate = this.$library.dayjs.pattern("YYYY-MM-DD HH:mm").format(this.$library.dayjs(comment.updatedat));
          const newComment = {
            id: comment.id,
            pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
            author: `<span class="author-entry"><img src="${comment.authoravatar}" width="30px" height="30px" />${comment.authorname}</span>`,
            content,
            updatedAt: publishDate,
            type: this.tableIcon(typeIcons[comment.type], "--color-blue-700", comment.type),
            spamlevel: comment.spamlevel > 0 ? this.tableIcon("flag", "--color-red-700") : "",
            verified: comment.verified ? this.tableIcon("sparkling", "--color-yellow-700") : "",
            published: comment.published ? this.tableIcon("preview", "--color-green-700") : this.tableIcon("hidden", "--color-red-700")
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
      },
      tableIcon(icon, color, title = "") {
        return `<span title="${title}"><svg aria-hidden="true" data-type="${icon}" class="k-icon" style="color: var(${color});"><use xlink:href="#icon-${icon}"></use></svg></span>`;
      }
    }
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-komments-view" }, [_c("k-table", { attrs: { "columns": this.visibleColumns, "index": true, "rows": this.commentList, "empty": "No comments found", "pagination": { page: _vm.pagination.page, limit: _vm.pagination.limit, total: _vm.pagination.total, details: true } }, on: { "paginate": function($event) {
      _vm.pagination.page = $event.page;
    } }, scopedSlots: _vm._u([{ key: "header", fn: function({ columnIndex, label }) {
      return [_c("span", { attrs: { "title": label } }, [columnIndex === "verified" ? _c("k-icon", { staticStyle: { "color": "var(--color-yellow-700)" }, attrs: { "type": "sparkling" } }) : columnIndex === "spamlevel" ? _c("k-icon", { staticStyle: { "color": "var(--color-red-700)" }, attrs: { "type": "flag" } }) : columnIndex === "published" ? _c("k-icon", { staticStyle: { "color": "var(--color-green-700)" }, attrs: { "type": "preview" } }) : columnIndex === "type" ? _c("k-icon", { staticStyle: { "color": "var(--color-blue-700)" }, attrs: { "type": "box" } }) : _c("span", [_vm._v(_vm._s(label))])], 1)];
    } }, { key: "options", fn: function({ row }) {
      return [_c("k-options-dropdown", { attrs: { "options": _vm.dropdownOptions(row) } })];
    } }]) })], 1);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns
  );
  __component__.options.__file = "/Users/mauricerenck/Sites/kirby-plugins/komments/src/components/fields/CommentsTable.vue";
  const CommentsTable = __component__.exports;
  panel.plugin("mauricerenck/komments", {
    components: {
      "k-komments-view": View,
      CommentContent,
      CommentsTable,
      TableIcon,
      "komments-detail-drawer": DrawerDetails,
      "komments-reply-drawer": DrawerReply
    },
    fields: {
      CommentsTable
    },
    icons: {
      "indie-mention": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C13.6418 20 15.1681 19.5054 16.4381 18.6571L17.5476 20.3214C15.9602 21.3818 14.0523 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V13.5C22 15.433 20.433 17 18.5 17C17.2958 17 16.2336 16.3918 15.6038 15.4659C14.6942 16.4115 13.4158 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C13.1258 7 14.1647 7.37209 15.0005 8H17V13.5C17 14.3284 17.6716 15 18.5 15C19.3284 15 20 14.3284 20 13.5V12ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"></path></svg>',
      "indie-repost": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4H21C21.5523 4 22 4.44772 22 5V12H20V6H6V9L1 5L6 1V4ZM18 20H3C2.44772 20 2 19.5523 2 19V12H4V18H18V15L23 19L18 23V20Z"></path></svg>',
      "indie-sent": '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4.99989 13.9999L4.99976 5L6.99976 4.99997L6.99986 11.9999L17.1717 12L13.222 8.05024L14.6362 6.63603L21.0001 13L14.6362 19.364L13.222 17.9497L17.1717 14L4.99989 13.9999Z"></path></svg>'
    }
  });
})();
