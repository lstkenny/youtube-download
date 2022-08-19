class Output {
	static write(string, color = false, style = false, eol = "") {
		//	no text styling
		if (!color && !style) {
			process.stdout.write(string + eol)
			return
		}
		//	styled text
		const colors = {
			BLACK: 30,
			RED: 31,
			GREEN: 32,
			YELLOW: 33,
			BLUE: 34,
			MAGENTA: 35,
			CYAN: 36,
			WHITE: 37,
			BLACKBG: 40,
			REDBG: 41,
			GREENBG: 42,
			YELLOWBG: 43,
			BLUEBG: 44,
			MAGENTABG: 45,
			CYANBG: 46,
			WHITEBG: 47,
		}
		const styles = {
			RESET: 0,
			BOLD: 1,
			DIM: 2,
			UNDERLINE: 4,
			BLINK: 5,
			INVERSE: 7,
			HIDDEN: 8,
		}
		const colorCode = colors[color] || colors.WHITE
		const styleCode = styles[style] || styles.RESET
		process.stdout.write(`\x1b[${styleCode};${colorCode}m${string}\x1b[0m${eol}`)
	}
	static writeln(string, color, style) {
		Output.write(string, color, style, "\r\n")
	}
	static json(data, pretty = 4) {
		Output.writeln(JSON.stringify(data, null, pretty))
	}
	static error(string) {
		Output.writeln(string, "RED")
	}
	static warning(string) {
		Output.writeln(string, "YELLOW")
	}
	static success(string) {
		Output.writeln(string, "GREEN")
	}
	static clear() {
		console.clear()
	}
}

module.exports.Output = Output