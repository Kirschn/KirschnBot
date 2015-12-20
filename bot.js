var irc = require("irc"),
    mysql = require('mysql'),
    util = require("util"),
    request = require("request");
    fs = require("fs"),
    gotcredfromstdin = false,
    configfile = String(fs.readFileSync("config.dong", "utf-8")).split(",,"),
    botusername = "kirschnbot",
    ismaster = true,
        subprocesses = [],
        activebotprocessnames = [],
        spawn = require('child_process').spawn,
        mail = require("sendmail")(),
        linkregex = /\:\/\//ig,
        timer = [];
var concat = require('concat-stream');
var JSONStream = require('JSONStream');
var strawpoll = require('strawpoll');
util.log("KirschnBot V2.0.0.0");
util.log("Starting Connection to SQL Server");
process.stdin.setEncoding('utf8');
process.stdin.on('readable', function() {
    var chunk = process.stdin.read();
    if (chunk !== null) {
        console.log("Got Data from STDIN");
        if (chunk.split("||") !== chunk) {
            data = chunk.split("||");
            console.log("Got Data from STDIN");
            if (data[0]=="youare") {
                ismaster = false;
                gotcredfromstdin = true;
                botusername = data[1];
                botoauthtoken = data[2];
            }
        }
    }
});

console.log("sysready");
setTimeout(function() {
    if (!gotcredfromstdin) {
        botoauthtoken = configfile[0];
    }


    var sqlconnection = mysql.createConnection({
            host: '127.0.0.1',
            user: 'kirschnbot',
            password: configfile[1],
            database: 'kirschnbot'
        }),
        sysconf = {
            modchan: ['#kirschnbot', '#kirschnkiller'],
            globaladmins: ['kirschnkiller', 'shusky2812', "kirschnbot", 'thekirschn'],
            globaladminuserlevel: 0
        };

    sqlconnection.connect(function (err) {
        if (err) {
            console.error('error connecting: ' + err.stack);
            return;
        }

        console.log('connected as id ' + sqlconnection.threadId);
    });

    util.log("Connecting to IRC");
    var client = new irc.Client('irc.twitch.tv', botusername,
        {
            userName: botusername,
            realName: botusername,
            port: 6667,
            localAddress: null,
            debug: true,
            showErrors: true,
            autoRejoin: true,
            autoConnect: true,
            channels: [],
            secure: false,
            selfSigned: false,
            certExpired: false,
            floodProtection: false,
            floodProtectionDelay: 1000,
            sasl: false,
            stripColors: false,
            channelPrefixes: "&#",
            messageSplit: 512,
            encoding: '',
            password: botoauthtoken
        }
    );

    var activebots = {
        commands: {},
        users: {},
        config: {}
    };
    util.log("Init Complete");

    function isglobaladmin(username) {
        util.log("IS global admin: " + username);
        if (sysconf.globaladmins.indexOf(username) !== -1) {
            return true;
        } else {
            return false;
        }
    }

    function ismodapi(username, channel) {
        if (activebots["users"][channel]["mods"].indexOf(username) !== -1) {
            return true;
        } else {
            return false;
        }
    }

    function ischannelowner(username, channel) {
        if (username == channel.substr(1, channel.length)) {
            return true;
        } else {
            return false;
        }
    }

    function getuserlevel(username, channel, nextcode) {
        if (isglobaladmin(username)) {
            nextcode(sysconf.globaladminuserlevel);
        } else {
            if (username !== channel.substr(1, channel.length)) {
                if (ismodapi(username, channel)) {
                    nextcode(activebots["users"][channel].modlevel);
                } else {
                    if (activebots["users"][channel]["cache"][username] == undefined) {
                        util.log("SQL GETTING");
                        sqlconnection.query("SELECT userlevel FROM users WHERE (channel=\"" + channel + "\" OR channel=\"global\") AND username=\"" + username + "\";", function (err, results) {
                            if (!err) {
                                if (results[0] == undefined) {
                                    if (ismodapi(username, channel)) {
                                        var usrlevel = activebots["users"][channel].modlevel;
                                    } else {
                                        var usrlevel = activebots["users"][channel].regularlevel;
                                    }

                                } else {
                                    var usrlevel = results[0]["userlevel"];
                                }
                                activebots["users"][channel]["cache"][username] = usrlevel;
                                nextcode(usrlevel);
                            } else {
                            }
                        });
                    } else {
                        util.log("CACHE GETTING");
                        nextcode(activebots["users"][channel]["cache"][username]);
                    }
                }
            } else {
                nextcode(5);
            }

        }
    }

    function refreshbotconfig(channel) {
        refreshbotcommands(channel);
        refreshbotusers(channel);
        sqlconnection.query("SELECT linkfilter, blacklistfilter, linktolength, blacklisttolength, linktotext, blacklisttotext, maxtoul, silentto, silentlinkto, silentblacklistto, id FROM botconfig WHERE channel=" + mysql.escape(channel) + ";", function (err, results) {
            if (err == null) {
                activebots["config"][channel] = {};
                activebots["config"][channel].linkfilter = (results[0].linkfilter == "0") ? false : true;
                activebots["config"][channel].blacklistfilter = (results[0].blacklistfilter == "0") ? false : true;
                activebots["config"][channel].linktolength = results[0].linktolength;
                activebots["config"][channel].linktotext = results[0].linktotext;
                activebots["config"][channel].blacklisttotext = results[0].blacklisttotext;
                activebots["config"][channel].blacklisttolength = results[0].blacklisttolength;
                activebots["config"][channel].maxtoul = results[0].maxtoul;
                activebots["config"][channel].slientto = (results[0].silentto == "0") ? false : true;
                activebots["config"][channel].silentlinkto = (results[0].silentlinkto == "0") ? false : true;
                activebots["config"][channel].slientblacklistto = (results[0].silentblacklistto == "0") ? false : true;
                activebots["config"][channel].permit = "";
                activebots["config"][channel].id = results[0].id;
            }
        });
        sqlconnection.query("SELECT link FROM linkwhitelist WHERE channel=" + mysql.escape(channel) + " OR channel=" + mysql.escape("global") + ";", function(err, results) {
            if (err == null) {
                activebots["config"][channel].linkwhitelist = results;
            } else {
                activebots["config"][channel].linkwhitelist = [];
            }
        });
        sqlconnection.query("SELECT word FROM wordblacklist WHERE channel=" + mysql.escape(channel) + ";", function(err, results) {
            if (err == null) {
                activebots["config"][channel].blacklistwords = results;
            } else {
                activebots["config"][channel].blacklistwords = [];
            }
        });
    }

    function refreshbotusers(channel) {
        var sql = "SELECT useuserapi , modlevel , regularlevel FROM botconfig WHERE channel='" + channel + "';";
        sqlconnection.query(sql, function (err, results) {
            activebots["users"][channel] = {
                modlevel: results[0].modlevel,
                regularlevel: results[0].regularlevel,
                useapi: results[0].useuserapi,
                mods: [],
                cache: []
            };
            if (activebots["users"][channel].useapi == "1") {
                util.log("Using API for Channel " + channel);
                request('https://tmi.twitch.tv/group/user/' + channel.substr(1, channel.length) + '/chatters', function (error, response, body) {
                    if (!error && response.statusCode == 200) {
                        body = JSON.parse(body);
                        activebots["users"][channel]["mods"] = body["chatters"]["moderators"].concat(body["chatters"]["staff"]).concat(body["chatters"]["admins"])
                            .concat(body["chatters"]["global_mods"]);

                    }
                })
            } else {
                util.log("NO API");
            }
        })
    }

    function refreshbotcommands(channel) {
        var sql = 'SELECT userlevel, text, channel, commandname FROM commands WHERE channel="' + channel + '";';
        sqlconnection.query(sql, function (err, results) {
            if (err == null) {
                if (results[0] !== undefined) {
                    activebots["commands"][channel] = results;

                }
            } else {
                console.log("SQL ERROR: " + err);
            }
        })
    }


    function join(channel) {
            util.log("Start: Joining Channel: " + channel);
            sqlconnection.query("SELECT id, ircusername, ircoauthtoken FROM botconfig WHERE channel='" + channel + "';", function (err, results) {
                var ircconfig = results;
                if (activebots["config"][channel] == undefined) {
                    util.log("Start join, channel not active");
                    if (results[0] == undefined) {
                        util.log("Channel not existant");
                        var sql = "INSERT INTO  `kirschnbot`.`botconfig` (`id` , `channel` , `isactive`) VALUES ( NULL ,  '" + channel + "' , 'true' );";
                        sqlconnection.query(sql, function (err, results) {
                            if (err == null) {
                                //join complete
                                refreshbotconfig(channel);
                                setTimeout(function () {
                                    client.join(channel);
                                }, 900);
                                util.log("Bot Database Build: " + results);
                            } else {
                                util.log("Error while building Bot Database: " + err);
                            }
                        });
                    } else {
                        var sql = 'UPDATE botconfig SET isactive=\'true\' WHERE channel=\'' + channel + '\';',
                            botid = results[0]['id'];
                        sqlconnection.query(sql, function (err, results) {
                            util.log("Global Channel ID: " + botid);

                            console.log(ircconfig);
                            console.log("IRC username: |" + ircconfig[0].ircusername + "| Botusername: |" + botusername + "|");
                            if (String(ircconfig[0].ircusername) == String(botusername)) {
                                util.log("Joining as current client");
                                activebots["config"][channel] = {
                                    id: botid
                                };
                                refreshbotconfig(channel);
                                setTimeout(function () {
                                    client.join(channel);
                                }, 900);
                            } else {
                                util.log("IRC Username for Channel not the same, writing Task to other instance and/or building one");
                                var sql = 'INSERT INTO bottodo (type, channel, chatbot, initby) VALUES ("join", ' + mysql.escape(channel) + ', ' + mysql.escape(ircconfig[0].ircusername) + ', ' + mysql.escape("instancehandler") + ');';
                                sqlconnection.query(sql, function (err, results) {
                                    if (err !== null) {
                                        console.log("SQL ERROR: " + err);
                                    }
                                });
                                if (activebotprocessnames.indexOf(ircconfig[0].ircusername) == -1) {
                                    util.log("Building new Bot Instance");
                                    activebotprocessnames.push(ircconfig[0].ircusername);
                                    subprocesses[ircconfig[0].ircusername] = spawn("bash");
                                    setTimeout(function () {
                                        console.log("Writing IRC Credentials");
                                        subprocesses[ircconfig[0].ircusername].stdin.write("youare||" + ircconfig[0].ircusername + "||" + ircconfig[0].ircoauthtoken + "||\n");
                                    }, 500);
                                    subprocesses[ircconfig[0].ircusername].stdout.on('data', function (data) {
                                        console.log("STDOUT FORK " + ircconfig[0].ircusername + ": " + data)
                                    });
                                    subprocesses[ircconfig[0].ircusername].stderr.on('data', function (data) {
                                    });
                                    subprocesses[ircconfig[0].ircusername].on('exit', function (data) {
                                    });
                                    subprocesses[ircconfig[0].ircusername].stdin.write("node bot.js\n");


                                }
                            }
                        });

                    }
                } else {
                    util.log("Join stopped, channel already active");
                }
            })

    }

    function leave(channel) {
        if (sysconf.modchan.indexOf(channel) !== -1) {
            return "Modchannel";
        } else {
            if (activebots["config"][channel] !== undefined) {
                var sql = 'UPDATE botconfig SET isactive=NULL WHERE channel=\'' + channel + '\';';
                sqlconnection.query(sql, function (err, results) {
                    if (err == null) {
                        client.part(channel, "Leaving " + channel);
                        activebots["config"][channel] = undefined;
                    } else {
                        console.log(err);
                    }
                });
            }
            activebots["config"][channel] = undefined;
        }
    }

    function addcommand(commandname, text, userlevel, channel, creator, callback) {
        var date = new Date();
      var sql = 'INSERT INTO commands (commandname, text, userlevel, channel, creator, createtime) VALUES (' + sqlconnection.escape(commandname) + ', ' + sqlconnection.escape(text) + ' , ' + sqlconnection.escape(userlevel) + ', ' + sqlconnection.escape(text) + sqlconnection.escape(creator) + ', ' + date.toJSON() + ');';
        sqlconnection.query(sql, function (err, results) {
            if (err == null) {
                util.log("Added Command: " + sqlconnection.escape(commandname));
                callback();
            } else {
                console.log(err);
            }
        });
    }
    function builddatafrombotold(channel) {
        var commands = fs.readdirSync("/home/nodejs/nodescripts/produktivumgebung/bots/" + channel + "/commands");
        commands.forEach(function(current) {
            if (fs.existsSync("/home/nodejs/nodescripts/produktivumgebung/bots/" + channel + "/commands/" + current + "/text") && fs.existsSync("/home/nodejs/nodescripts/produktivumgebung/bots/" + channel + "/commands/" + current + "/userlevel")) {
                var date = new Date();
                var sql = 'INSERT INTO commands (commandname, text, userlevel, channel, creator, createtime) VALUES (' + sqlconnection.escape(current) + ', ' + sqlconnection.escape(fs.readFileSync("/home/nodejs/nodescripts/produktivumgebung/bots/" + channel + "/commands/" + current + "/text")) + ' , ' + sqlconnection.escape(fs.readFileSync("/home/nodejs/nodescripts/produktivumgebung/bots/" + channel + "/commands/" + current + "/userlevel", "utf-8").replace("6", "999").replace("4", "100").replace("2", "5").replace("5", "500")) + ', ' + sqlconnection.escape("#" + channel) + ", " + sqlconnection.escape("?") + ', ' + sqlconnection.escape(date.toJSON()) + ');';
                sqlconnection.query(sql, function(err) {
                    if (err !== null) {
                        console.log(err)
                    } else {
                        console.log("Command " + current + "@" + channel + " eingetragen");
                    }
                })
            }
        });


    }
    function createstrawpoll(pollname, answers, callback) {
        var stream = strawpoll({
            title: pollname,
            options: answers,
            multi: false,
            permissive: true
        })
            .pipe(JSONStream.parse('id'))
            .pipe(concat(function(id) {
                // `id` is a Buffer here
                // `id.toString()` is your poll's id
                callback(id.toString());
            }));
    }
    if (ismaster && !gotcredfromstdin && botusername == "kirschnbot") {
        setTimeout(function () {
          var sql = "SELECT channel FROM botconfig WHERE isactive=\"true\";";
            sqlconnection.query(sql, function (err, results) {
                if (!err) {
                    results.forEach(function (current) {
                        console.log("JOINING: " + current.channel);
                        join(current.channel);

                    });
                } else {
                    console.log(err);
                }
            });
        }, 2000);
    }
    function getrandomlistfromitem(listname, channel) {
        var sql = "SELECT item FROM useritems WHERE list=" + mysql.escape(listname) + ", channel=" + mysql.escape(channel) + " ORDER BY RAND() LIMIT 1;"
        sqlconnection.query(sql, function (results) {
            if (results[0] !== undefined) {

            }
        });
    }
    // Startet Timer im RAM
    function starttimer (channel, text, interval, name) {
        if (timer[channel] == undefined) {
            timer[channel] = [];
        }
        timer[channel][name] = setInterval(function() {
            client.say(channel, text);
        }, interval * 1000);
    }
    // Stoppt Timer im RAM
    function stoptimer (channel, name) {
        clearInterval(timer[channel][name]);
    }
    // Erstellt neuen Timer in der Datenbank
    function createtimer (channel, text, interval, name, active) {
        var sql = "INSERT INTO timer (text, name, timerinterval, channel, active) VALUES (" + mysql.escape(text) + ", " + mysql.escape(name) + ", " + mysql.escape(interval) + ", " + mysql.escape(channel) + ", " + mysql.parse(active) +");"
        sqlconnection.query(sql);
        if (active) {
            starttimer(channel, text, interval, name);
        }
    }
    function loadandstarttimer (channel, name) {
        var sql = "SELECT text, timerinterval FROM timer WHERE channel="+ mysql.escape(channel) + " AND name=" + mysql.escape(name) + ";";
        sqlconnection.query(sql, function (err, results) {
            if (results[0] !== undefined) {
                starttimer(channel, results[0].text, results[0].timerinterval, name);
                client.say(channel, "Timer "+ name + " started successfully (Interval: " + results[0].timerinterval + " minutes");
            } else {
                // TImer existiert nicht
            }
        })
    }
    function handlecommand(handlemessage, channel, callback, username, triggercommand) {
        util.log("Looping " + ((handlemessage.match(/\$/g) || []).length+1) + " Times");
        var handlesplit = handlemessage.split(" ");
        var splittrigger = triggercommand.split(" ");
        for (i=0; i < ((handlemessage.match(/\$/g) || []).length+1); i++) {
            splittrigger = triggercommand.split(" ");
            if (handlemessage.indexOf("$qelseuser") !== -1) {
                var query = triggercommand.replace(splittrigger[0], "");
                console.log("Handlemessage: " + handlemessage);
                console.log("Triggercommand: " + triggercommand);
                util.log("Replacing $queryelseuser with " + query);
                if (splittrigger[1] !== undefined) {
                    handlemessage = handlemessage.replace("$qelseuser", query);
                } else {
                    handlemessage = handlemessage.replace("$qelseuser", username);
                }
            }
        }
            handlesplit.forEach(function (current) {
                if (current.indexOf("]elseuser") > current.indexOf("$[")) {
                    var triggercommandwordindex = parseInt(current.replace("$[", "").replace("]elseuser", ""));
                    if (splittrigger[triggercommandwordindex] !== undefined) {
                        handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elseuser", splittrigger[triggercommandwordindex]);
                    } else {
                        handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elseuser", username);
                    }
                }

                if (current.indexOf("$[") < current.indexOf("]elserngnumber(") && current.indexOf("]elserngnumber(") < current.indexOf(",") && current.indexOf(",") < current.indexOf(")")) {
                    util.log("Found RNG Number Parsing in word " + current);
                    var triggercommandwordindex = parseInt(current.replace("$[", "").split("]else")[0]);
                    var rngstring = current.replace("$[" + triggercommandwordindex + "]elserngnumber(", "").replace(")", "");
                    var splitrngstring = rngstring.split(",");
                    var min = parseInt(splitrngstring[0]);
                    var max = parseInt(splitrngstring[1]);
                    if (splittrigger[triggercommandwordindex] !== undefined) {
                        handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elserngnumber(" + min + "," + max + ")", splittrigger[triggercommandwordindex]);
                    } else {
                        if (parseInt(splitrngstring[0]) < parseInt(splitrngstring[1])) {
                            var random = Math.round(Math.random() * (max - min)) + min;
                            util.log("RNG String: " + rngstring + " | min: " + min + " | max: " + max + " | RNG: "+random);
                            handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elserngnumber(" + min + "," + max + ")", random);
                        }
                    }
                }
                if (current.indexOf("$[") < current.indexOf("]elserngitem(") && current.indexOf("]elserngitem(") < current.indexOf(")")) {
                    util.log("Found RNG List Parsing in word " + current);
                    var triggercommandwordindex = parseInt(current.replace("$[", "").split("]else")[0]);
                    var rngstring = current.replace("$[" + triggercommandwordindex + "]elserngitem(", "").replace(")", "");
                    if (splittrigger[triggercommandwordindex] !== undefined) {
                        handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elserngitem(" + rngstring + ")", splittrigger[triggercommandwordindex]);
                    } else {
                            handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elserngitem(" + rngstring + ")", "$[rnglist(" + rngstring + ")]");

                    }
                }
                if (current.indexOf("$[") < current.indexOf("]elsetext(") && current.indexOf("]elsetext(") < current.indexOf(")")) {
                    util.log("Found Text Parsing in word " + current);
                    var triggercommandwordindex = parseInt(current.replace("$[", "").split("]else")[0]);
                    var rngstring = current.replace("$[" + triggercommandwordindex + "]elserngitem(", "").replace(")", "");
                    if (splittrigger[triggercommandwordindex] !== undefined) {
                        handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elsetext(" + rngstring + ")", splittrigger[triggercommandwordindex]);
                    } else {
                        handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]elsetext(" + rngstring + ")", "rngstring");

                    }
                }
                if (current.indexOf("$rngnumber(") < current.indexOf(",") && current.indexOf(",") < current.indexOf(")")) {
                    util.log("Found RNG Number Parsing in word " + current);
                    var rngstring = current.replace("$rngnumber(", "").replace(")", "");
                    var splitrngstring = rngstring.split(",");
                    var min = parseInt(splitrngstring[0]);
                    var max = parseInt(splitrngstring[1]);
                        if (parseInt(splitrngstring[0]) < parseInt(splitrngstring[1])) {
                            var random = Math.round(Math.random() * (max - min)) + min;
                            util.log("RNG String: " + rngstring + " | min: " + min + " | max: " + max + " | RNG: "+random);
                            handlemessage = handlemessage.replace("$rngnumber(" + min + "," + max + ")", random);
                        }

                }

                //TODO: Definiertes Item else RNG Item
                // Unten Syntax für Defines RNG Itemnamen angeben, Hier das Else Statement mit dem entsprechenden Syntax  ersetzen


                //if (current.indexOf("]") > current.indexOf("$[")) {
                //    var triggercommandwordindex = parseInt(current.replace("$[", "").replace("]", ""));
                //   if (splittrigger[triggercommandwordindex] !== undefined) {
                //        handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]", splittrigger[triggercommandwordindex]);
                //1   } else {
                //      handlemessage = handlemessage.replace("$[" + triggercommandwordindex + "]", "");
                //  }
                //}
            });

            util.log("Preextraparse Ok, current Handlemessage: " + handlemessage + " (triggercommand: " + triggercommand + ") Loop " + i);


        if (handlemessage.replace("$[", "") !== handlemessage) {
            util.log("Parsing extra command parameters");
            var othercommand = handlemessage.split("$[");
            var current = othercommand[1];
                if (current.indexOf("]" !== -1)) {
                    current = current.split("]");
                    if (current[0] !== undefined || current[0] !== "" || current[0] !== " ") {

                        if (current[0].indexOf("counter(") !== -1) {
                            // var countername = String(current[0].split(")")).replace("counter(", "").replace(",", "");
                            // addcounter(countername.replace("counter(", ""));
                            // console.log("[BOT " + CHANNEL + "]: " +fs.readFileSync("counter/" + countername + ".txt"));
                            // fs.readFile("counter/" + countername.toLowerCase() + ".txt", function (err, data) {
                            //    handlemessage = handlemessage.replace("$[counter(" + countername + ")]", data);
                            //    client.say(channel, handlemessage);
                            // });


                        } else if (current[0].indexOf("rnglist(") !== -1) {
                            var listname = String(current[0].split(")")).replace("rnglist(", "").replace(",", "");
                            var sql = "SELECT item FROM useritems WHERE list=" + mysql.escape(listname) + " AND (channel=" + mysql.escape(channel) + " OR channel=\"global\") ORDER BY RAND() LIMIT 1;";
                            sqlconnection.query(sql, function (err, results) {
                                if (results[0] !== undefined) {
                                    callback(handlemessage.replace("$[rnglist(" + listname + ")]", results[0]["item"]));
                                } else {
                                    callback(handlemessage.replace("$[rnglist(" + listname + ")]", "[empty or invalid list]"));
                                }
                            });




                        } else if (current[0].indexOf("http(") !== -1) {
                            var url = String(current[0].split(")")[0]).replace("http(", "").replace(",", "");
                            if (url.length < 500) {
                                request(url, function (error, response, body) {
                                    if (response == undefined) {
                                     callback(handlemessage.replace(url, "Invalid Syntax"));
                                    } else {
                                        if (!error && response.statusCode == 200) {
                                            console.log("HTTP Request ok")
                                        } else {
                                            body = "HTTP: " + response.statusCode;
                                        }
                                        handlemessage = handlemessage.replace("$[http(" + url + ")]", String(body).substr(0, 400).replace(/\n|\r/g, ""));
                                        callback(handlemessage);
                                    }
                                })

                            }




                        } else {
                            callback(handlemessage);
                        }

                    }
                } else {
                    //Syntaxfehler
                }



        } else {
            util.log("No more Params, starting callback function");
            callback(handlemessage);
        }

    }
    client.on('motd', function (motd) {
        util.log("MOTD: " + motd);
    });


    client.on('join', function (channel, nick, message) {
        util.log("JOIN: " + channel + " : " + nick + " : " + message);
    });

    client.addListener('pm', function (from, message) {
        util.log(from + ' => Bot: ' + message);
    });
    client.on('raw', function (message) {
        if (message.args[1] == "Error logging in" && message.command == "NOTICE") {
            mail({
                    from: 'kirschnbotservice@kirschn.de',
                    to: 'support@kirschn.de',
                    subject: 'KIRSCHNBOT HIGH LEVEL ISSUE: Account Management failure',
                    content: 'Error logging in: ' + botusername + '@irc.twitch.tv:6667'
                },
                function(err,response){
                    if(err){
                        console.log(err);
                    }
                    console.dir(response);
                    process.exit();
                });

        }
    });
    client.on('error', function (message) {
        console.log("ERROR: " + message.nick + " -> " + message.command + "(" + message.args + ")");
    });
    client.on('message', function (nick, channel, text, message) {
        util.log("MESSAGE " + channel + " => " + nick + " => " + text);
        if (activebots["config"][channel].linkfilter) {
            if(linkregex.test(text)) {
                util.log("Found Link in Message from " + nick);
                getuserlevel(nick, channel, function(ul) {
                    util.log("Initalizing Timeout for Message from " + nick + "(UL: " + ul + ")");
                    if (activebots["config"][channel].permit !== nick) {
                    if (ul >= activebots["config"][channel].maxtoul && !ismodapi(nick, channel)) {

                            activebots["config"][channel].linkwhitelist.forEach(function (current) {
                                if (text.indexOf(current.link) == -1) {
                                    client.say(channel, ".timeout " + nick + " " + activebots["config"][channel].linktolength);
                                    if (!activebots["config"][channel].silentto && !activebots["config"][channel].silentlinkto) {
                                        setTimeout(function () {
                                                client.say(channel, nick + " -> " + activebots["config"][channel].linktotext);
                                            }, 500
                                        );
                                        setTimeout(function() {
                                            client.say(channel, ".timeout " + nick + " " + activebots["config"][channel].linktolength);
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    } else {
                        activebots["config"][channel].permit = "";
                    }
                });


            }
        }
        if (activebots["config"][channel].blacklistfilter) {
            var textlowercase = text.toLowerCase();
            activebots["config"][channel].blacklistwords.forEach(function (current) {
                if (textlowercase.indexOf(current.word) !== -1) {
                    getuserlevel(nick, channel, function(ul) {
                        if (ul >= activebots["config"][channel].maxtoul) {
                            client.say(channel, ".timeout " + nick + " " + activebots["config"][channel].blacklisttolength);
                            if (!activebots["config"][channel].silentto && !activebots["config"][channel].silentblacklistto) {
                                setTimeout(function () {
                                        client.say(channel, nick + " -> " + activebots["config"][channel].blacklisttotext);
                                    }, 500
                                );
                                setTimeout(function() {
                                    client.say(channel, ".timeout " + nick + " " + activebots["config"][channel].linktolength);
                                }, 1000);
                            }
                        }
                    });
                }
            })
        }
        console.time("commandexec");
        console.time("usercommandexec");
        if (text[0] == "!") {
            var splitmessagelowercase = text.toLowerCase().split(" ");
            var splitmessagenormal = text.split(" ");
            sqlconnection.query('SELECT userlevel, text FROM commands WHERE channel="' + channel + '" AND commandname="' + splitmessagelowercase[0].replace(/'/g, "") + '" ;', function (err, results) {
                if (results[0] !== undefined) {
                    getuserlevel(nick, channel, function (usrlevel) {
                        if (results[0].userlevel >= usrlevel) {
                            // PARAMETER HANDLEN
                            handlecommand(results[0].text, channel, function (callback) {
                                client.say(channel, String(callback).replace("$username", nick)
                                    .replace("$query", text.replace(splitmessagenormal[0] + " ", ""))
                                    .replace("$user", nick));
                                console.timeEnd("usercommandexec");
                            }, nick, text);

                        }
                    });
                }
            });

            // GLOBAL COMMANDS

            if (splitmessagelowercase[0] == "!botinfo") {
                client.say(channel, "KirschnBot V2.0.1.6 | Global Bot: ID" + activebots["config"][channel]["id"]);
            } else if (splitmessagelowercase[0] == "!getuserlevel") {
                getuserlevel(splitmessagelowercase[1], channel, function (usrlevel) {
                    client.say(channel, nick + " -> " + usrlevel);
                });

            }
            if (splitmessagelowercase[0] == "!dumpvar" && isglobaladmin(nick)) {
                client.say(channel, eval(String(text).replace("!dumpvar ", "")));
            }
            //MODCOMMANDS
            if (splitmessagelowercase[0] == "!leave" || splitmessagelowercase[0] == "!kbotleave") {
                getuserlevel(nick, channel, function (level) {
                    if (level <= activebots["users"][channel].modlevel) {
                        client.say(channel, nick + " -> Leaving Channel");
                        leave(channel);
                    }
                });
            }
            if (splitmessagelowercase[0] == "!additem" && splitmessagelowercase[1] !== undefined && splitmessagelowercase[2] !== undefined) {
                if (splitmessagelowercase[2].indexOf("-name=") !== -1) {
                    var itemname = splitmessagenormal.split("=")[1];
                    var sql = "INSERT INTO  `kirschnbot`.`useritems` (`id` , `channel` , `item` , `list` , `itemname` ) VALUES ( NULL , " + mysql.escape(channel) +  ",  " + mysql.escape(splitmessagenormal[3]) +  ",  '" + mysql.escape(splitmessagelowercase[1]) +  "',  " + mysql.escape(itemname) + ");";
                } else {
                    var sql = "INSERT INTO  `kirschnbot`.`useritems` (`id` , `channel` , `item` , `list` , `itemname` ) VALUES ( NULL , " + mysql.escape(channel) + ",  " + mysql.escape(splitmessagenormal[2]) + ",  '" + mysql.escape(splitmessagelowercase[1]) + "',  '');";
                }
                sqlconnection.query(sql, function(err, results) {
                   if (err == null) {
                       client.say(channel, nick + " -> Item added");
                   }
                });
            }
            if (splitmessagelowercase[0] == "!removeitem" && splitmessagelowercase[1] !== undefined && splitmessagelowercase[2] !== undefined) {
                if (splitmessagelowercase[2].indexOf("-name=") !== -1) {
                    var itemname = splitmessagenormal.split("=")[1];
                    var sql = "INSERT INTO  `kirschnbot`.`useritems` (`id` , `channel` , `item` , `list` , `itemname` ) VALUES ( NULL , " + mysql.escape(channel) +  ",  " + mysql.escape(splitmessagenormal[3]) +  ",  '" + mysql.escape(splitmessagelowercase[1]) +  "',  'datfrankerz');";
                } else {
                    var sql = "INSERT INTO  `kirschnbot`.`useritems` (`id` , `channel` , `item` , `list` , `itemname` ) VALUES ( NULL , " + mysql.escape(channel) + ",  " + mysql.escape(splitmessagenormal[2]) + ",  '" + mysql.escape(splitmessagelowercase[1]) + "',  'datfrankerz');";
                }
                sqlconnection.query(sql, function(err, results) {
                    if (err == null) {
                        client.say(channel, nick + " -> Item added");
                    }
                });
            }
            if (splitmessagelowercase[0] == "!strawpoll") {
                getuserlevel(nick, channel, function (level) {
                    if (level <= activebots["users"][channel].modlevel) {
                        if (splitmessagenormal[3] !== undefined) {
                            var answers = text.replace(splitmessagenormal[0] + " " + splitmessagenormal[1] + " ", "").split(" ");
                            console.log(answers);
                            createstrawpoll(splitmessagenormal[1], answers, function(id) {
                                client.say(channel, nick + " -> Poll \"" + splitmessagenormal[1] + "\" created: http://strawpoll.me/"+id);
                            })
                        }
                    }
                })
            }
            if (splitmessagelowercase[0] == "!addcom" || splitmessagelowercase[0] == "!addcommand") {
                getuserlevel(nick, channel, function (level) {
                    if (level <= activebots["users"][channel].modlevel) {

                        util.log("ADDCOM: Nutzerlevel des Erstellers akzeptiert");
                        if (splitmessagelowercase[1] !== undefined && splitmessagelowercase[2] !== undefined) {
                            if (activebots["commands"][channel] == undefined) {
                                activebots["commands"][channel] = {};
                            }
                            if (activebots["commands"][channel][splitmessagelowercase[1]] == undefined) {
                                var level = activebots["users"][channel].regularlevel,
                                    startattwo = true;

                                if (isNaN(splitmessagelowercase[1])) {
                                    if (splitmessagelowercase[1] == "-ul=mod" || splitmessagelowercase[1] == "-ul=moderator" || splitmessagelowercase[1] == "mod" || splitmessagelowercase[1] == "moderator") {
                                        util.log("Parsing Userlevel as: Mod");
                                        level = activebots["users"][channel].modlevel;
                                    } else if (splitmessagelowercase[1] == "-ul=reg" || splitmessagelowercase[1] == "-ul=regular" || splitmessagelowercase[1] == "reg" || splitmessagelowercase[1] == "regular" || splitmessagelowercase[1] == "-ul=viewer" || splitmessagelowercase[1] == "viewer") {
                                        util.log("Parsing Userlevel as: Regular");
                                        level = activebots["users"][channel].regularlevel;
                                    } else if (splitmessagelowercase[1] == "-ul=streamer" || splitmessagelowercase[1] == "streamer") {
                                        util.log("Parsing Userlevel as: Streamer");
                                        level = 5;
                                    } else {
                                        startattwo = false;
                                        level = activebots["users"][channel].regularlevel;
                                    }
                                } else {
                                    util.log("Writing Raw Userlevel to Database");
                                    level = splitmessagelowercase[1];
                                }
                                if (startattwo) {
                                    if (splitmessagelowercase[2].substr(0, 1) == "!") {
                                        var commandname = splitmessagelowercase[2];
                                    } else {
                                        var commandname = "!" + splitmessagelowercase[2];
                                    }
                                    var commandtext = text.replace("!addcom " + splitmessagenormal[1] + " " + splitmessagenormal[1] + " ", "");
                                } else {
                                    if (splitmessagelowercase[1].substr(0, 1) == "!") {
                                        var commandname = splitmessagelowercase[1];
                                    } else {
                                        var commandname = "!" + splitmessagelowercase[1];
                                    }
                                    var commandtext = text.replace("!addcom " + splitmessagenormal[1] + " ", "");
                                }
                                var sql = 'INSERT INTO `commands`(`commandname`, `text`, `userlevel`, `channel`, `creator`, `createtime`) VALUES ("' + mysql.escape(commandname).substr(1, commandname.length) + '","' + mysql.escape(commandtext).substr(1, commandtext.length) + '","' + level + '","' + channel + '","' + nick + '","' + new Date().toJSON() + '");';
                                util.log("SQL: " + sql);
                                sqlconnection.query(sql, function (err, results) {
                                    if (err == null) {
                                        util.log("Added Command to Database");
                                        client.say(channel, nick + " -> Added command " + commandname);
                                        refreshbotcommands(channel);
                                    } else {
                                        console.log("SQL ERROR: " + err);
                                    }
                                })
                            } else {
                                client.say(channel, nick + " -> Command already exists");
                            }
                        } else {
                            // INVALID COMMAND SYNTAX
                            client.say(channel, nick + " -> Invalid Syntax, correct: !addcom -ul=mod !mycommand My Text");
                            util.log("ADDCOM: Invalid Command Syntax");
                        }

                    }
                });
            }
            if (splitmessagelowercase[0] == "!editcom" || splitmessagelowercase[0] == "!editcommand") {
                getuserlevel(nick, channel, function (level) {
                    if (level <= activebots["users"][channel].modlevel) {
                        if (splitmessagelowercase[1] == "userlevel") {
                            var level = activebots["users"][channel].regularlevel;
                            if (isNaN(splitmessagelowercase[3])) {
                                if (splitmessagelowercase[3] == "-ul=mod" || splitmessagelowercase[3] == "-ul=moderator" || splitmessagelowercase[3] == "mod" || splitmessagelowercase[3] == "moderator") {
                                    util.log("Parsing Userlevel as: Mod");
                                    level = activebots["users"][channel].modlevel;
                                } else if (splitmessagelowercase[3] == "-ul=reg" || splitmessagelowercase[3] == "-ul=regular" || splitmessagelowercase[3] == "reg" || splitmessagelowercase[3] == "regular" || splitmessagelowercase[3] == "-ul=viewer" || splitmessagelowercase[3] == "viewer") {
                                    util.log("Parsing Userlevel as: Regular");
                                    level = activebots["users"][channel].regularlevel;
                                } else if (splitmessagelowercase[3] == "-ul=streamer" || splitmessagelowercase[3] == "streamer") {
                                    util.log("Parsing Userlevel as: Streamer");
                                    level = 5;
                                } else {
                                    level = activebots["users"][channel].regularlevel;
                                }
                            } else {
                                util.log("Writing Raw Userlevel to Database");
                                level = parseInt(splitmessagelowercase[3]);
                            }
                            if (splitmessagelowercase[2].substr(0, 1) == "!") {
                                splitmessagelowercase[2] = splitmessagelowercase[2];
                            } else {
                                splitmessagelowercase[2] = "!" + splitmessagelowercase[2];
                            }
                          var sql = "UPDATE commands SET userlevel=\"" + level + "\" WHERE channel=\"" + channel + "\" AND commandname=" + mysql.escape(splitmessagelowercase[2]) +";";
                            sqlconnection.query(sql, function (err, results) {
                                if (err == null) {
                                    refreshbotconfig(channel);
                                    client.say(channel, nick + " -> Update successful");
                                } else {
                                    console.log("SQL ERROR: " + err);
                                }
                            })
                        } else if (splitmessagelowercase[1] == "text" && splitmessagenormal[3] !== undefined) {
                            var instext = text.replace(splitmessagenormal[0] + " text " + splitmessagenormal[2] + " ", "");
                          var sql = "UPDATE commands SET text=" + mysql.escape(instext) + " WHERE channel=\"" + channel + "\" AND commandname=" + mysql.escape(splitmessagelowercase[2]) + ";";
                            sqlconnection.query(sql, function (err, results) {
                                if (err == null) {
                                    refreshbotconfig(channel);
                                    client.say(channel, nick + " -> Update successful");
                                } else {
                                    console.log("SQL ERROR: " + err);
                                }
                            });

                        } else {
                            client.say(channel, nick + " -> Command Syntax Error (!editcommand text !yourcommand new text or !editcommand userlevel !yourcommand moderator)");
                        }
                        // TODO: Rename Command Function

                    }
                });
            }
            if (splitmessagelowercase[0] == "!delcom" || splitmessagelowercase[0] == "!deletecommand") {
                getuserlevel(nick, channel, function (level) {
                    if (level <= activebots["users"][channel].modlevel) {
                        if (splitmessagelowercase[1].substr(0, 1) == "!") {
                            var commandname = splitmessagelowercase[1];
                        } else {
                            var commandname = "!" + splitmessagelowercase[1];
                        }
                        // CHECK IF COMMAND EXISTS
                        util.log("SQL: SELECT id FROM commands WHERE commandname=" + mysql.escape(commandname) + ";");
                        sqlconnection.query("SELECT id FROM commands WHERE commandname=" + mysql.escape(commandname) + ";", function (err, results) {
                            if (results[0] !== undefined) {
                                sqlconnection.query("DELETE FROM `commands` WHERE `id`=" + results[0].id + ";", function (err, results) {
                                    if (err == null) {
                                        client.say(channel, nick + " -> Delete successful");
                                        refreshbotconfig(channel);
                                    }
                                });
                            } else {
                                client.say(channel, nick + " -> This command doesn't exist");
                            }
                        });

                    }
                });
            }
            if (splitmessagelowercase[0] == "!permit") {
                getuserlevel(nick, channel, function (level) {
                    if (splitmessagelowercase[1] !== undefined) {
                        activebots["config"][channel].permit = splitmessagelowercase[1];
                        client.say(channel, nick + " -> " + splitmessagelowercase[1] + " was given permission to post a link.");
                    }
                });
            }
            //MODCHANNELCOMMANDS
            if (sysconf.modchan.indexOf(channel) > -1) {
                if (splitmessagelowercase[0] == "!join") {
                    if (splitmessagelowercase[1] == undefined) {
                        client.say(channel, "Joining Channel...");
                        join("#" + nick);
                    } else {
                        if (splitmessagelowercase[1][0] !== "#") {
                            splitmessagelowercase[1] = "#" + splitmessagelowercase[1]
                        }
                        getuserlevel(nick, channel, function (usrlevel) {
                            if (usrlevel <= 4) {
                                join(splitmessagelowercase[1]);
                                client.say(channel, nick + " -> Joining #" + splitmessagelowercase[1]);
                            }
                        })
                    }
                } else if (splitmessagelowercase[0] == "!part") {
                    if (splitmessagelowercase[1][0] !== "#") {
                        splitmessagelowercase[1] = "#" + splitmessagelowercase[1]
                    }
                    getuserlevel(nick, channel, function (usrlevel) {
                        if (usrlevel <= 4) {
                            var leavereturn = leave(splitmessagelowercase[1]);
                            if (leavereturn !== undefined) {
                                client.say(channel, nick + " -> Error: " + leavereturn);
                            } else {
                                client.say(channel, nick + " -> Leaving #" + splitmessagelowercase[1]);
                            }
                        }
                    })
                }
            }
            console.timeEnd('commandexec');
        }
    });


// TODOCRAWLER

    function getinteractions() {
      var sql = "SELECT * FROM bottodo WHERE chatbot=" + mysql.escape(botusername) + ";";
        sqlconnection.query(sql, function (err, results) {
            if (results[0] !== undefined) {
                console.log("Found Actions in Control Table: " + results);
                // THERE IS SOMETHING TO DO!
                results.forEach(function (current) {
                    if (current.type == "reinit") {
                        refreshbotconfig(current.channel);
                    } else if (current.type == "join") {
                        join(current.channel);
                    } else if (current.type == "part") {
                        leave(current.channel);
                    } else if (current.type == "addcommand") {
                        if (activebots["commands"][current.channel][current.name] == undefined) {
                          var sql = 'INSERT INTO `commands`(`commandname`, `text`, `userlevel`, `channel`, `creator`, `createtime`) VALUES ("' + mysql.escape(current.name).substr(1, current.name.length) + '",' + mysql.escape(current.text) + ',"' + current.userlevel + '","' + current.channel + '","' + current.initby + '","' + new Date().toJSON() + '");';
                            util.log("SQL: " + sql);
                            sqlconnection.query(sql, function (err, results) {
                                if (err !== null) {
                                    console.log("SQL ERROR: " + err);
                                }
                            })
                        } else {

                        }
                    } else if (current.type == "deletecommand") {
                      var sql = 'DELETE FROM `commands` WHERE `commandname`=' + mysql.escape(current.name) + ";";
                        sqlconnection.query(sql);
                    } else if (current.type == "editcommandusrlevel") {
                      var sql = "UPDATE commands SET userlevel=\"" + current.userlevel + "\" WHERE channel=\"" + current.channel + "\" AND commandname=\"" + current.name + "\";";
                        sqlconnection.query(sql);
                    } else if (current.type == "editcommandtext") {
                      var sql = "UPDATE commands SET text=\"" + current.text + "\" WHERE channel=\"" + current.channel + "\" AND commandname=\"" + current.name + "\";";
                        sqlconnection.query(sql);
                    } else if (current.type="buildbot") {
                        var sql = "";
                        sqlconnection.query(sql);
                    }
                  var sql = "INSERT botactionsdone (type, channel, chatbot, initby, name, userlevel, text) SELECT type, channel, chatbot, initby, name, userlevel, text FROM bottodo WHERE id=" + mysql.escape(current.id) + ";";
                    sqlconnection.query(sql, function (err, results) {
                        if (err !== null) {
                            console.log("SQL ERROR: " + err);
                        } else {
                          var sql = "DELETE FROM `bottodo` WHERE `id`=" + mysql.escape(current.id) + ";";
                            sqlconnection.query(sql, function (err, results) {
                                if (err !== null) {console.log("SQL ERR: "+ err)};
                            });
                        }

                    })
                })

            }
        })
    }

    controlloop = setInterval(function () {
        getinteractions();
    }, 1000);
}, 2000);