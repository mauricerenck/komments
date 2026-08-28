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
  const _sfc_main$6 = {
    props: {
      queuedKomments: Object,
      affectedPages: Array,
      webmentions: Boolean,
      showMigration: Boolean,
      storageType: String,
      isVerificationEnabled: Boolean,
      queuedVerifications: Object,
      verificationTtl: Number
    },
    data() {
      return {
        relatedComment: null
      };
    },
    methods: {
      markRelatedComment(id) {
        this.relatedComment = id;
      }
    }
  };
  var _sfc_render$6 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-panel-inside", [_c("div", { staticClass: "k-komments-view" }, [_vm.showMigration ? _c("div", [_c("k-headline", { attrs: { "tag": "h2" } }, [_vm._v("Converter")]), _c("Converter", { attrs: { "storageType": this.storageType } })], 1) : _c("div", [_c("k-headline", { attrs: { "tag": "h2" } }, [_vm._v("Comments")]), _c("CommentsTable", { attrs: { "comments": this.queuedKomments, "affectedPages": this.affectedPages, "webmentions": this.webmentions, "storageType": this.storageType, "relatedComment": this.relatedComment, "markRelatedComment": _vm.markRelatedComment } }), _vm.isVerificationEnabled ? _c("div", [_c("k-headline", { attrs: { "tag": "h2" } }, [_vm._v("Pending Verifications")]), _c("TokenTable", { attrs: { "queuedVerifications": this.queuedVerifications, "relatedComment": this.relatedComment, "markRelatedComment": _vm.markRelatedComment, "verificationTtl": _vm.verificationTtl } })], 1) : _vm._e()], 1)])]);
  };
  var _sfc_staticRenderFns$6 = [];
  _sfc_render$6._withStripped = true;
  var __component__$6 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$6,
    _sfc_render$6,
    _sfc_staticRenderFns$6
  );
  __component__$6.options.__file = "/Volumes/T7/sites/kirby-plugins/komments/src/components/View.vue";
  const View = __component__$6.exports;
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
          comment: this.content,
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
    return _c("k-drawer", _vm._b({}, "k-drawer", _vm.$props, false), [this.replyCreated ? _c("k-box", { key: "created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "positive", "text": "Your reply has been published." } }) : this.replyCreated === false ? _c("k-box", { key: "not-created", staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "theme": "negative", "text": "Your reply could not be published. Please try again." } }) : _vm._e(), _c("CommentContent", { attrs: { "spamlevel": _vm.comment.spamlevel, "content": _vm.comment.content, "avatar": _vm.comment.authoravatar } }), _c("div", { staticClass: "k-table k-komments-to-margin" }, [_c("table", { staticStyle: { "table-layout": "auto" } }, [_c("tbody", [_c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Created at")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(" " + _vm._s(this.$library.dayjs(_vm.comment.createdate).format("YYYY-MM-DD HH:mm")) + " ")])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Author")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorname))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Email")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authoremail))])]), _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Url")]), _c("td", { attrs: { "data-mobile": "true" } }, [_vm._v(_vm._s(_vm.comment.authorurl))])]), _vm.comment.spamlevel > 0 ? _c("tr", [_c("th", { attrs: { "data-mobile": "true" } }, [_vm._v("Spamlevel")]), _c("td", { attrs: { "data-mobile": "true" } }, [_c("k-progress", { attrs: { "value": _vm.comment.spamlevel } })], 1)]) : _vm._e()])])]), _c("k-textarea-field", { staticStyle: { "margin-bottom": "var(--spacing-2)", "margin-top": "var(--spacing-6)" }, attrs: { "autofocus": true, "label": `Reply to ${_vm.comment.authorname}`, "value": _vm.content }, on: { "input": function($event) {
      _vm.content = $event;
    } } }), _c("k-button", { key: "green", attrs: { "theme": "green", "variant": "filled", "icon": _vm.isSending ? _vm.loader : null, "disabled": _vm.isSending }, on: { "click": this.sendReply } }, [_vm._v(" Send reply " + _vm._s(!this.originPublished && "and publish") + " ")])], 1);
  };
  var _sfc_staticRenderFns$5 = [];
  _sfc_render$5._withStripped = true;
  var __component__$5 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$5,
    _sfc_render$5,
    _sfc_staticRenderFns$5
  );
  __component__$5.options.__file = "/Volumes/T7/sites/kirby-plugins/komments/src/components/DrawerDetails.vue";
  const DrawerDetails = __component__$5.exports;
  const _sfc_main$4 = {
    props: {
      icon: String,
      color: String
    }
  };
  var _sfc_render$4 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("svg", { staticClass: "k-icon", style: `color: var(${this.color})`, attrs: { "aria-hidden": "true", "data-type": this.icon } }, [_c("use", { attrs: { "xlink:href": `#icon-${this.icon}` } })]);
  };
  var _sfc_staticRenderFns$4 = [];
  _sfc_render$4._withStripped = true;
  var __component__$4 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$4,
    _sfc_render$4,
    _sfc_staticRenderFns$4
  );
  __component__$4.options.__file = "/Volumes/T7/sites/kirby-plugins/komments/src/components/TableIcon.vue";
  const TableIcon = __component__$4.exports;
  const _sfc_main$3 = {
    props: {
      spamlevel: Number,
      content: String,
      avatar: String
    }
  };
  var _sfc_render$3 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_c("k-grid", [_c("k-box", { staticStyle: { "--width": "1/5" }, domProps: { "innerHTML": _vm._s(_vm.avatar) } }), _c("k-box", { staticStyle: { "margin-bottom": "var(--spacing-6)", "--width": "4/5" } }, [_c("k-box", { attrs: { "theme": "text" } }, [_vm.spamlevel === 0 ? _c("k-text", { domProps: { "innerHTML": _vm._s(_vm.content) } }) : _c("k-text", [_vm._v(_vm._s(_vm.content))])], 1)], 1)], 1)], 1);
  };
  var _sfc_staticRenderFns$3 = [];
  _sfc_render$3._withStripped = true;
  var __component__$3 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$3,
    _sfc_render$3,
    _sfc_staticRenderFns$3
  );
  __component__$3.options.__file = "/Volumes/T7/sites/kirby-plugins/komments/src/components/fields/CommentContent.vue";
  const CommentContent = __component__$3.exports;
  const _sfc_main$2 = {
    props: {
      comments: Object,
      affectedPages: Array,
      columns: Array,
      webmentions: Boolean,
      storageType: String,
      relatedComment: String,
      markRelatedComment: Function
    },
    data() {
      return {
        pagination: {
          page: 1,
          limit: 20,
          total: 0
        },
        selectMode: false,
        selection: []
      };
    },
    watch: {
      relatedComment(commentId) {
        if (!commentId) {
          return;
        }
        this.showCommentDetails(commentId);
      }
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
          "status",
          "type"
        ];
        const visibleColumns = this.columns || availableColumns;
        const filteredColumns = visibleColumns.filter((column) => availableColumns.includes(column));
        const columnConfigs = {
          author: { label: "Author", type: "html" },
          content: { label: "Comment", type: "text" },
          pageTitle: { label: "Page", type: "html" },
          updatedAt: { label: "Last Update", type: "html" },
          spamlevel: { label: "Spamlevel", type: "html", width: "40px", align: "center" },
          verified: { label: "Verified", type: "html", width: "40px", align: "center" },
          status: { label: "Status", type: "html", width: "40px", align: "center" },
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
          const publishDate = this.$library.dayjs(comment.updatedat).format("YYYY-MM-DD HH:mm");
          let statusIcon;
          switch (comment.verification_status) {
            case "VERIFIED":
              statusIcon = "circle-half";
              break;
            case "PUBLISHED":
              statusIcon = "check";
              break;
            default:
              statusIcon = "clock";
              break;
          }
          const newComment = {
            id: comment.id,
            pageTitle: `<a href="${pageOfComment.panel}">${pageOfComment.title}</a>`,
            author: `<span class="author-entry">${comment.authoravatar} ${comment.authorname}</span>`,
            content,
            updatedAt: publishDate,
            type: this.tableIcon(typeIcons[comment.type], "--color-blue-700", comment.type),
            spamlevel: comment.spamlevel > 0 ? this.tableIcon("flag", "--color-red-700") : "",
            verified: comment.verified ? this.tableIcon("badge", "--color-yellow-700") : "",
            status: this.tableIcon(statusIcon, "--color-black")
          };
          commentList.push(newComment);
          this.pagination.total++;
        });
        return commentList.slice(this.index - 1, this.pagination.limit * this.pagination.page);
      },
      hasSpamComments() {
        return this.comments.some((comment) => comment.spamlevel > 0);
      },
      hasPendingComments() {
        return this.comments.some((comment) => comment.published === false);
      }
    },
    methods: {
      removeMarkedComment() {
        this.markRelatedComment(null);
      },
      showCommentDetails(id) {
        const comment = this.comments.find((comment2) => comment2.id === id);
        panel.drawer.open({
          component: "komments-detail-drawer",
          props: {
            icon: "chat",
            title: "Comment",
            comment
          },
          on: {
            submit: () => {
              this.removeMarkedComment();
            },
            cancel: () => {
              this.removeMarkedComment();
            },
            close: () => {
              this.removeMarkedComment();
            }
          }
        });
      },
      publishComment(id) {
        panel.api.post(`komments/publish/${id}`).then((response) => {
          this.comments.find((item) => item.id === id).published = response.published;
          this.comments.find((item) => item.id === id).status = response.published ? "PUBLISHED" : "PENDING";
        });
      },
      publishPendingComments() {
        panel.dialog.open(`comments/publish/pending`);
      },
      publishSelectedComments() {
        this.flagSelectedComments("published");
      },
      deleteComment(id) {
        panel.dialog.open(`comment/delete/${id}`);
      },
      deleteSpamComments() {
        panel.dialog.open(`comments/delete/spam`);
      },
      markSelectedCommentsAsSpam() {
        this.flagSelectedComments("spamlevel");
      },
      markSelectedCommentsAsVerified() {
        this.flagSelectedComments("verified");
      },
      deletePendingComments() {
        panel.dialog.open(`comments/delete/pending`);
      },
      deleteSelectedComments() {
        panel.api.post(`komments/batch-delete`, { ids: this.selection }).then((response) => {
          if (response.success === true) {
            this.selection = [];
            this.selectMode = false;
            panel.reload();
          }
        });
      },
      flagComment(id, type) {
        panel.api.post(`komments/flag/${id}/${type}`).then((response) => {
          this.comments.find((item) => item.id === id)[type] = response[type];
        });
      },
      flagSelectedComments(type) {
        panel.api.post(`komments/batch-flag`, { type, ids: this.selection }).then((response) => {
          if (response.success === true) {
            this.selection = [];
            this.selectMode = false;
            panel.reload();
          }
        });
      },
      dropdownOptions(row) {
        const comment = this.comments.find((item) => item.id === row.id);
        return [
          {
            label: "Reply to",
            icon: "chat",
            click: () => this.showCommentDetails(row.id)
          },
          "-",
          {
            label: comment.published ? "Unpublish" : "Publish",
            icon: comment.published ? "toggle-on" : "toggle-off",
            click: () => this.publishComment(row.id)
          },
          {
            label: comment.verified ? "Mark as unverified" : "Mark as verified",
            icon: comment.verified ? "cancel-small" : "badge",
            disabled: comment.spamlevel > 0,
            click: () => this.flagComment(row.id, "verified")
          },
          {
            label: comment.spamlevel > 0 ? "Remove from spam" : "Mark as spam" + row.spamlevel,
            icon: comment.spamlevel > 0 ? "cancel-small" : "flag",
            click: () => this.flagComment(row.id, "spamlevel")
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
      },
      toggleSelect() {
        this.selectMode = !this.selectMode;
      },
      selectRow(row) {
        const index = this.selection.indexOf(row.id);
        if (index > -1) {
          this.selection.splice(index, 1);
        } else {
          this.selection.push(row.id);
        }
      },
      openDrawer(cell) {
        const commentId = cell.row.id;
        const blockedColumns = ["spamlevel", "verified"];
        if (blockedColumns.indexOf(cell.columnIndex) !== -1) {
          switch (cell.columnIndex) {
            case "spamlevel":
              this.flagComment(commentId, "spamlevel");
              break;
            case "verified":
              this.flagComment(commentId, "verified");
              break;
          }
          return;
        }
        this.showCommentDetails(commentId);
      }
    }
  };
  var _sfc_render$2 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-komments-view" }, [this.storageType !== "markdown" ? _c("k-button-group", { staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "layout": "collapsed" } }, [_c("k-button", { attrs: { "variant": "filled", "icon": "checklist", "click": this.toggleSelect } }, [_vm._v(" Select ")]), this.selectMode === true ? _c("k-button", { attrs: { "variant": "filled", "icon": "toggle-off", "theme": "green", "disabled": this.selection.length === 0, "click": this.publishSelectedComments } }, [_vm._v(" Publish " + _vm._s(this.selection.length) + " ")]) : _vm._e(), this.selectMode === true ? _c("k-button", { attrs: { "variant": "filled", "icon": "badge", "theme": "yellow", "disabled": this.selection.length === 0, "click": this.markSelectedCommentsAsVerified } }, [_vm._v(" Verify " + _vm._s(this.selection.length) + " ")]) : _vm._e(), this.selectMode === true ? _c("k-button", { attrs: { "variant": "filled", "icon": "flag", "theme": "orange", "disabled": this.selection.length === 0, "click": this.markSelectedCommentsAsSpam } }, [_vm._v(" Spam " + _vm._s(this.selection.length) + " ")]) : _vm._e(), this.selectMode === true ? _c("k-button", { attrs: { "variant": "filled", "icon": "trash", "theme": "red", "disabled": this.selection.length === 0, "click": this.deleteSelectedComments } }, [_vm._v(" Delete " + _vm._s(this.selection.length) + " ")]) : _vm._e(), this.selectMode === false ? _c("k-button", { attrs: { "variant": "filled", "icon": "toggle-off", "theme": "green-icon", "disabled": !this.hasPendingComments, "click": this.publishPendingComments } }, [_vm._v(" Publish all ")]) : _vm._e(), this.selectMode === false ? _c("k-button", { attrs: { "variant": "filled", "icon": "flag", "theme": "orange-icon", "disabled": !this.hasSpamComments, "click": this.deleteSpamComments } }, [_vm._v(" Delete spam ")]) : _vm._e(), this.selectMode === false ? _c("k-button", { attrs: { "variant": "filled", "icon": "trash", "theme": "red-icon", "disabled": !this.hasPendingComments, "click": this.deletePendingComments } }, [_vm._v(" Delete all pending ")]) : _vm._e()], 1) : _vm._e(), _c("k-table", { attrs: { "columns": this.visibleColumns, "index": true, "rows": this.commentList, "empty": "No comments found", "selecting": this.selectMode, "pagination": { page: _vm.pagination.page, limit: _vm.pagination.limit, total: _vm.pagination.total, details: true } }, on: { "cell": _vm.openDrawer, "paginate": function($event) {
      _vm.pagination.page = $event.page;
    }, "select": _vm.selectRow }, scopedSlots: _vm._u([{ key: "header", fn: function({ columnIndex, label }) {
      return [_c("span", { attrs: { "title": label } }, [columnIndex === "verified" ? _c("k-icon", { staticStyle: { "color": "var(--color-yellow-700)" }, attrs: { "type": "badge" } }) : columnIndex === "spamlevel" ? _c("k-icon", { staticStyle: { "color": "var(--color-red-700)" }, attrs: { "type": "flag" } }) : columnIndex === "status" ? _c("k-icon", { staticStyle: { "color": "var(--color-green-700)" }, attrs: { "type": "preview" } }) : columnIndex === "type" ? _c("k-icon", { staticStyle: { "color": "var(--color-blue-700)" }, attrs: { "type": "box" } }) : _c("span", [_vm._v(_vm._s(label))])], 1)];
    } }, { key: "options", fn: function({ row }) {
      return [_c("k-options-dropdown", { attrs: { "options": _vm.dropdownOptions(row) } })];
    } }]) })], 1);
  };
  var _sfc_staticRenderFns$2 = [];
  _sfc_render$2._withStripped = true;
  var __component__$2 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$2,
    _sfc_render$2,
    _sfc_staticRenderFns$2
  );
  __component__$2.options.__file = "/Volumes/T7/sites/kirby-plugins/komments/src/components/fields/CommentsTable.vue";
  const CommentsTable = __component__$2.exports;
  const _sfc_main$1 = {
    props: {
      queuedVerifications: Object,
      relatedComment: String,
      verificationTtl: Number,
      markRelatedComment: Function
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
        return {
          hash: { label: "Hash", type: "text" },
          commentId: { label: "Comment ID", type: "text" },
          createdAt: { label: "Created", type: "html" },
          expiresAt: { label: "Expires", type: "html" }
        };
      },
      tokenList() {
        if (!this.queuedVerifications) {
          return [];
        }
        const tokenList = [];
        this.pagination.total = 0;
        this.queuedVerifications.forEach((token) => {
          const createdDate = this.$library.dayjs.pattern("YYYY-MM-DD HH:mm").format(this.$library.dayjs(token.created_at));
          const now = this.$library.dayjs();
          const expires = this.$library.dayjs(token.expires_at * 1e3);
          const differenceInMinutes = expires.diff(now, "minute");
          const percentageLeft = 100 / (this.verificationTtl * 60) * differenceInMinutes;
          const finalPercentage = Math.max(0, Math.min(100, percentageLeft));
          const newEntry = {
            hash: token.hash,
            commentId: token.comment_id,
            createdAt: createdDate,
            expiresAt: this.renderProgressBar(finalPercentage)
          };
          tokenList.push(newEntry);
          this.pagination.total++;
        });
        return tokenList.slice(this.index - 1, this.pagination.limit * this.pagination.page);
      }
    },
    methods: {
      markComment(cell) {
        const commentId = cell.row.commentId;
        this.markRelatedComment(commentId);
      },
      deleteExpiredToken() {
        panel.dialog.open(`tokens/delete/expired`);
      },
      renderProgressBar(value) {
        const percentage = Math.min(100, Math.max(0, value));
        let cssClass = "";
        if (percentage < 10) {
          cssClass = "is-danger";
        } else if (percentage < 25) {
          cssClass = "is-warning";
        }
        return `<progress class="${cssClass}" value="${value}" max="100"></progress>`;
      }
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-komments-view" }, [this.storageType !== "markdown" ? _c("k-button-group", { staticStyle: { "margin-bottom": "var(--spacing-6)" }, attrs: { "layout": "collapsed" } }, [_c("k-button", { attrs: { "variant": "filled", "icon": "trash", "theme": "orange", "click": this.deleteExpiredToken, "disabled": _vm.queuedVerifications.length === 0 } }, [_vm._v(" Cleanup ")])], 1) : _vm._e(), _c("k-table", { attrs: { "columns": this.visibleColumns, "index": true, "rows": this.tokenList, "empty": "No pending verifications", "pagination": { page: _vm.pagination.page, limit: _vm.pagination.limit, total: _vm.pagination.total, details: true } }, on: { "paginate": function($event) {
      _vm.pagination.page = $event.page;
    }, "cell": _vm.markComment } })], 1);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1
  );
  __component__$1.options.__file = "/Volumes/T7/sites/kirby-plugins/komments/src/components/fields/TokenTable.vue";
  const TokenTable = __component__$1.exports;
  const _sfc_main = {
    props: {
      storageType: String
    },
    data() {
      return {
        status: "idle",
        comments: [],
        queue: [],
        processIndex: 0,
        processRunning: false,
        progressValue: 0
      };
    },
    computed: {
      conversionList() {
        return this.comments.map((item) => {
          return {
            conversionStatus: `<span class="status ${item.conversionStatus}">${item.conversionStatus}</span>`,
            pageUuid: item.pageUuid,
            pageTitle: item.pageTitle,
            comments: item.comments,
            converted: item.converted,
            failed: item.failed
          };
        });
      }
    },
    methods: {
      getComments() {
        this.status = "in-progress";
        panel.api.get(`komments/converter/get-comments`).then((response) => {
          const comments = [];
          response.forEach((item) => {
            const queueEntry = { ...item, ...{ queueStatus: "idle" } };
            this.queue.push(queueEntry);
            const page = comments.find((entry2) => entry2.pageUuid === item.pageUuid);
            if (page) {
              page.comments++;
              return;
            }
            const entry = {
              conversionStatus: "idle",
              pageUuid: item.pageUuid,
              pageTitle: item.pageTitle,
              comments: 1,
              converted: 0,
              failed: 0
            };
            comments.push(entry);
          });
          this.comments = comments;
          this.processQueue();
        });
      },
      processQueue() {
        const limit = 1;
        this.progressValue = 100 / this.queue.length * this.processIndex;
        if (this.processIndex >= this.queue.length) {
          this.processIndex = 0;
          this.processRunning = false;
          return;
        }
        this.processRunning = true;
        const item = this.queue[this.processIndex];
        this.processIndex += limit;
        const tableEntry = this.comments.find((comment) => item.pageUuid === comment.pageUuid);
        tableEntry.conversionStatus = "running";
        panel.api.post(`komments/converter/convert`, item).then((response) => {
          const convertedComment = this.comments.find((comment) => item.pageUuid === comment.pageUuid);
          if (response.status === "success") {
            convertedComment.converted++;
          } else {
            convertedComment.failed++;
          }
          tableEntry.conversionStatus = convertedComment.comments.length === convertedComment.converted + convertedComment.failed ? "success" : "done";
        }).then(() => {
          this.processQueue();
        });
      },
      convertComment(comment) {
        const tableEntry = this.comments.find((item) => item.pageUuid === comment.pageUuid);
        tableEntry.conversionStatus = "running";
        panel.api.post(`komments/converter/convert`, comment).then((response) => {
          const convertedComment = this.comments.find((item) => item.pageUuid === comment.pageUuid);
          if (response.status === "success") {
            convertedComment.converted++;
          } else {
            convertedComment.failed++;
          }
        });
      }
    }
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_c("k-grid", { attrs: { "variant": "fields" } }, [_vm.status === "in-progress" ? _c("k-box", { key: "inprogress", staticStyle: { "--width": "1/2", "margin-bottom": "var(--spacing-6)", "padding": "var(--spacing-6)", "display": "block" }, attrs: { "theme": _vm.progressValue >= 100 ? "positive" : "warning", "html": true } }, [_vm.progressValue < 100 ? _c("p", [_vm._v(" Conversion in progress, please wait. "), _c("strong", [_vm._v("DO NOT CLOSE THIS PAGE.")])]) : _c("div", [_c("p", [_c("strong", [_vm._v("Conversion complete!")])]), _c("k-checkboxes-field", { attrs: { "name": "checkboxes", "label": "Please complete the following steps:", "options": [
      { value: 1, text: "Check if all comments are converted" },
      { value: 2, text: "Go to your config.php and disable migration" },
      { value: 3, text: "Adapt your theme to the new comment format" },
      { value: 4, text: "Remove old comments from your page files" }
    ] } })], 1), _vm.progressValue < 100 ? _c("k-progress", { staticStyle: { "margin-top": "var(--spacing-6)" }, attrs: { "value": _vm.progressValue } }) : _vm._e()], 1) : _vm._e(), _c("div", { staticStyle: { "--width": "1/2", "margin-bottom": "var(--spacing-6)" } }, [_vm.status !== "in-progress" ? _c("k-box", { key: "info", staticStyle: { "padding": "var(--spacing-6)" }, attrs: { "theme": "info", "html": true, "text": "It seems like you used an older version of this plugin. We need to convert old comments to the new format. This will take a while. For data safety reasons, <strong>old comments will not be deleted automatically.</strong> You can delete them manually after the conversion.", "icon": "bell" } }) : _vm._e(), this.storageType === "markdown" ? _c("k-box", { key: "markdown", staticStyle: { "padding": "var(--spacing-6)", "margin-top": "var(--spacing-6)" }, attrs: { "theme": "error", "html": true, "text": "You set the storage type to Markdown. This means that comments will be stored in the page files. This may lead to issues when receiving a lot of comments at the same time. It is recommended to use a database storage type for better performance. Markdown storage also does not support batch operations. If you can, please consider switching to the sqlite storage type.", "icon": "bell" } }) : _vm._e()], 1), _vm.status !== "in-progress" ? _c("k-box", { staticStyle: { "--width": "1/4" }, attrs: { "align": "center" } }, [_c("k-button", { attrs: { "variant": "filled", "icon": "play", "theme": "green", "size": "lg", "click": this.getComments } }, [_vm._v(" Start conversion ")])], 1) : _vm._e()], 1), _c("k-table", { attrs: { "columns": {
      conversionStatus: { label: "Status", width: "160px", type: "html" },
      pageTitle: { label: "Page", type: "html" },
      comments: { label: "Comments", type: "text" },
      converted: { label: "Converted", type: "text" },
      failed: { label: "Failed", type: "text" }
    }, "index": true, "rows": _vm.conversionList, "empty": "No comments found" } })], 1);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns
  );
  __component__.options.__file = "/Volumes/T7/sites/kirby-plugins/komments/src/components/fields/Converter.vue";
  const Converter = __component__.exports;
  panel.plugin("mauricerenck/komments", {
    components: {
      "k-komments-view": View,
      CommentContent,
      CommentsTable,
      TokenTable,
      Converter,
      TableIcon,
      "komments-detail-drawer": DrawerDetails
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
