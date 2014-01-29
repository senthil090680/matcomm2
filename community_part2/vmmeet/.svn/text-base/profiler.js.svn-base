// 2004-05-17 Simple Profiler v. 0.1
// by Alex Kunin <alx at oxygenworks.net>

function Profiler(prefix, method) {
	this.prefix = prefix;
	this.method = method;
	this.start = (new Date()).getTime();
}

Profiler.reset = function () {
	Profiler.data = [];
}

Profiler.dump = function () {
	var html = '<body style="margin: 0; padding: 5px;"><button onclick="self.opener.Profiler.reset()">Reset</button><table width="100%" cellspacing="0" cellpadding="0"><col><col style="width: 10ex;"><col style="width: 10ex"><col style="width: 10ex"><tr style="font: bold 8pt tahoma;"><th>Method</th><th>Count</th><th>Avg.<br>time</th><th>Total<br>time</th></tr>';
	var data = [], i;
	for (var i in Profiler.data)
		data[data.length] = { method:i, count:Profiler.data[i].count, time:Profiler.data[i].time }
	data = data.sort(function (a, b) { return b.time - a.time } );
	for (var i in data)
		with (data[i])
			html += '<tr style="font: 8pt tahoma;"><td>' + i + ':' + method + '</td><td>' + count + '</td><td>' + (Math.round(time / count) / 1000) + '</td><td>' + (time / 1000) + "</td></tr>\n";
	html += '</table></body>';
	if (Profiler.window && !Profiler.window.closed && Profiler.window.document) {
		Profiler.window.document.body.innerHTML = html;
		setTimeout('Profiler.dump()', 1000);
	}	
}

Profiler.penetrate = function (className) {
	var prototype = window[className].prototype;
	window[className] = new Function(
		window[className].toString().match(/^.*\((.*)\)/)[1],
		window[className].toString().replace(/^.*?\{/, "{\n\tProfiler.install(this);")
	);
	window[className].prototype = prototype;
}

Profiler.install = function (instance) {
	if (Profiler.disabled)
		return;

	var prefix = instance.constructor.toString().match(/function\s+(\w+)/)[0];
	var i, list = [];
	for (i in instance)
		if (typeof(instance[i]) == 'function')
			list[list.length] = i;
	for (i in list) {
		instance[list[i] + '_orig'] = instance[list[i]];
		instance[list[i]] = new Function('var profiler = new Profiler("' + prefix + '", "' + list[i] + '"); var result = this.' + list[i] + '_orig.apply(this, arguments); profiler.fix(); return result');
	}
	if (!Profiler.window) {
		Profiler.window = window.open('about:blank', '_blank', 'width=400,height=500,resizable=1,scrollbars=1');
		setTimeout('Profiler.dump()', 1000);
		window.onunload = new Function("Profiler.window.close()");
	}
}

Profiler.data = [];

Profiler.prototype.fix = function () {
	this.finish = (new Date()).getTime();
	var index = this.prefix + '.' + this.method;
	if (!Profiler.data[index])
		Profiler.data[index] = { count:0, time:0 };
	with (Profiler.data[index]) {
		count++;
		time += this.finish - this.start;
	}
}


