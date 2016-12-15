Ext.provide('Phlexible.tasks.util.TaskManager');

Phlexible.tasks.util.TaskManager = {
    comment: function (task_id, comment, callback, scope) {
        Ext.Ajax.request({
            url: Phlexible.Router.generate('tasks_create_comment'),
            params: {
                id: task_id,
                comment: encodeURIComponent(comment)
            },
            callback: function(options, success, response) {
                if (callback) {
                    var result = Ext.decode(response.responseText);
                    callback.call(scope || this, success, result, options);
                }
            }
        });
    },

    assignToMe: function (task_id, callback, scope) {
        Ext.Ajax.request({
            url: Phlexible.Router.generate('tasks_assign'),
            params: {
                id: task_id,
                recipient: Phlexible.Config.get('user.id')
            },
            callback: function(options, success, response) {
                if (callback) {
                    var result = Ext.decode(response.responseText);
                    callback.call(scope || this, success, result, options);
                }
            }
        });
    },

    assign: function (task_id, recipient, comment, callback, scope) {
        Ext.Ajax.request({
            url: Phlexible.Router.generate('tasks_assign'),
            params: {
                id: task_id,
                recipient: recipient,
                comment: encodeURIComponent(comment)
            },
            callback: function(options, success, response) {
                if (callback) {
                    var result = Ext.decode(response.responseText);
                    callback.call(scope || this, success, result, options);
                }
            }
        });
    },

    setStatus: function (task_id, name, comment, callback, scope) {
        Ext.Ajax.request({
            url: Phlexible.Router.generate('tasks_create_transition'),
            params: {
                id: task_id,
                name: name,
                comment: encodeURIComponent(comment)
            },
            callback: function(options, success, response) {
                if (callback) {
                    var result = Ext.decode(response.responseText);
                    callback.call(scope || this, success, result, options);
                }
            }
        });
    },

    transition: function (task_id, name, recipient, comment, callback, scope) {
        Ext.Ajax.request({
            url: Phlexible.Router.generate('tasks_create_transition'),
            params: {
                id: task_id,
                name: name,
                recipient: recipient,
                comment: encodeURIComponent(comment)
            },
            callback: function(options, success, response) {
                if (callback) {
                    var result = Ext.decode(response.responseText);
                    callback(success, result, options);
                }
            },
            scope: scope || this
        });
    }
};
