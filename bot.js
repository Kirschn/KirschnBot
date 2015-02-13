// EDIT THIS

var IRCSERVER = 'irc.twitch.tv';
var USERNAME = 'kirschnbot';
var PASSWORD = '';
var CHANNEL = '#kirschnkiller';

//DON'T EDIT ANYTHING BELOW THIS


var irc = require("irc");
var fs = require("fs");
var http = require("http");


var systemversion = "1.0.0.52";

var commandlist;
var client = new irc.Client(IRCSERVER, USERNAME, {
    channels: [CHANNEL],
    password: PASSWORD
});
var debug = false;
var existscommand = false;

//USER CONFIG
var globaladmins;
var owner;
var admins;
var mods;
var regulars;


fs.readdir("commands", function(err, files) {
    		commandlist = files;
    		if (!err) {
    		} else {
    			console.log(err);
    		}
    	});
function readusers(channel) {
    var options = {
        host: 'kirschnkiller.de',
        path: '/kirschnbot/ga.php?ver=' + systemversion
    };

    callback = function(response) {
    var str = '';

    //another chunk of data has been recieved, so append it to `str`
    response.on('data', function (chunk) {
        str += chunk;
    });

    //the whole response has been recieved, so we just print it out here
    response.on('end', function () {
      var stringdata = String(str);
      var splitdata = stringdata.split(",");
      globaladmins = splitdata;
    });
    }

    http.request(options, callback).end();
  fs.readFile("users/admins.txt", function(err, data) {
      if (!err) {
          var stringdata = String(data);
          var splitdata = stringdata.split(",");
          admins = splitdata
      }
  })
  fs.readFile("users/mods.txt", function(err, data) {
      if (!err) {
          var stringdata = String(data);
          var splitdata = stringdata.split(",");
          mods = splitdata
      }
  })
  fs.readFile("users/regulars.txt", function(err, data) {
      if (!err) {
          var stringdata = String(data);
          var splitdata = stringdata.split(",");
          regulars = splitdata
      }
  })
};
readusers("kirschnkiller");

function isglobaladmin(name) {
    if (globaladmins.indexOf(name) !== -1) {
        return true;
    } else {
        return false;
    }
}
function ismod(name, channel) {
    if (mods.indexOf(name) !== -1) {
        return true;
    } else {
        return false;
    }
}
function isadmin(name) {
    if (admins.indexOf(name) !== -1) {
        return true;
    } else {
        return false;
    }
}
function isregular(name) {
    if (regulars.indexOf(name) !== -1) {
        return true;
    } else {
        return false;
    }
}
function isowner(name, channel, from) {
    if (name == channel) {
        if (name == from) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function getuserlevel(user, channel, from) {
    var userlevel = 6;
    if (isregular(user)) {
        userlevel = 5;
    } else {
        if (ismod(user, channel)) {
            userlevel = 4;
        } else {
            if (isadmin(user)) {
                userlevel = 3;
            } else {
                if (isowner(user, channel, from)) {
                    userlevel = 2;
                } else {
                    if (isglobaladmin(user)) {
                        userlevel = 1;
                    }
                }
            }
        }
    }
    return userlevel;
}

var options = {
  host: 'kirschnkiller.de',
  path: '/kirschnbot/index.php?ver=' + systemversion
};

callback = function(response) {
  var str = '';

  //another chunk of data has been recieved, so append it to `str`
  response.on('data', function (chunk) {
    str += chunk;
  });

  //the whole response has been recieved, so we just print it out here
  response.on('end', function () {
    console.log(str);
  });
}

http.request(options, callback).end();


client.addListener('message', function (from, to, message) {
    console.log(from + ' => ' + to + ': ' + message);
    if (message.indexOf("!kdebottest") == 0 ) {
    	client.say(to, "Testmessage in Kanal " + to + " von " + from);
    }
    if (message.indexOf("!debug") == 0) {
    	if (ismod(from)) {
    		debug = !debug;
    		client.say(to, "Debugmodus: " + String(debug));
    	} else {
    		client.say(to, from + " -> Du musst dafür Mod sein!");
    	}
    }
    if (message.indexOf("!level") == 0) {
    		debug = !debug;
    		var splitmessage = message.split(" ");
    		var channel = String(to.replace("#", ""));
    		client.say(to, splitmessage[1] + "s Userlevel: " + String(getuserlevel(splitmessage[1], channel, from)));
    	
    }
    if (message.indexOf("!addcom") == 0) {
        var splitmessage1 = message.split("|||");
        var splitmessage2 = splitmessage1[0].split(" ");
                fs.exists("commands/!" + splitmessage3[1], function(exists) {
            existscommand = exists;
        })
        if (getuserlevel(from, String(to.replace("#", "") >= 4))) {
            if (existscommand) {
                client.say(to, from + " -> Dieses Kommands existiert bereits!");
            } else {
                fs.mkdir("commands/!" + splitmessage2[1]);
                fs.writeFile("commands/!" + splitmessage2[1] + "/text", splitmessage1[1]);
                fs.writeFile("commands/!" + splitmessage2[1] + "/userlevel", splitmessage2[2]);
                client.say(to, from + " -> Das Kommando " + splitmessage1[0] + " wurde erfolgreich erstellt.");
            }
        }
    }
    if (message.indexOf("!removecom") == 0) {
        var splitmessage3 = message.split(" ");
        fs.exists("commands/!" + splitmessage3[1], function(exists) {
            existscommand = exists;
        })
        if (getuserlevel(from, String(to.replace("#", "") >= 4))) {
            
            if (existscommand) {
                client.say(to, from + " -> Dieses Kommando existiert nicht!");
            } else {
                fs.unlink("commands/!" + splitmessage3[1] + "/userlevel");
                fs.unlink("commands/!" + splitmessage3[1] + "/text");
                fs.rmdir("commands/!" + splitmessage3[1]);
                client.say(to, from + " -> Das Kommando " + splitmessage3[1] + " wurde erfolgreich gelöscht.");
            }
        }
    }
    if (message.indexOf("!renamecom") == 0) {
        var splitmessage3 = message.split(" ");
        var existscommand = false;
        fs.exists("commands/!" + splitmessage3[1], function(exists) {
            existscommand = exists;
        })
        if (getuserlevel(from, String(to.replace("#", "") >= 4))) {
            if (existscommand) {
                client.say(to, from + " -> Das Kommando " + splitmessage3[1] + " existiert nicht!");
            } else {
                fs.rename("commands/!" + splitmessage3[1], "commands/!" + splitmessage3[2]);
                client.say(to, from + " -> Das Kommando " + splitmessage3[1] + " wurde erfolgreich in " + splitmessage3[2] + " umbenannt.");
            }
        }
    }
    if (message.indexOf("!reinit") == 0) {
        if (getuserlevel(from, String(to.replace("#", "") >= 4))) {
    	client.say(to, "Lade Kommandoliste und Nutzer neu...");
    	fs.readdir("commands", function(err, files) {
    		commandlist = files;
    		if (!err) {
    		    readusers(to);
    			client.say(to, "Fertig!");
    		} else {
    			console.log(err);
    			client.say(to, "Fehler! Für nähere Informationen bitte in der Serverkonsole nachsehen.");
    		}
    	});
        }
    } 
    if (message.indexOf("!info") == 0) {
        client.say(to, "KDE IRC Bot V" + systemversion + " | 2015 Kirschnkiller")
    }
    var splitmessage = message.split(" ");
    if (commandlist.indexOf(splitmessage[0]) != -1) {
        fs.readFile("commands/" + splitmessage[0] + "/text", function(err, data) {
            if (!err) {
                    var datatext = data;
                    fs.readFile("commands/" + splitmessage[0] + "/userlevel", function(err, data) {
                        var news = String(to).split("#", "")
                        if (data >= getuserlevel(from, news[1])) {
                            client.say(to, from + ' -> ' + String(datatext).replace("$query", message.replace(splitmessage[0]+" ", "")));
                        }
                    })
            }
        });
    }
});
