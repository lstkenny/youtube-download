const readline = require('readline')

class Input {
	static set(key, value) {
		Input.flags[key] = value
	}
	static setFlags() {
		Input.flags = {}
		let curIndex = 0
		let curFlag = null
		process.argv.forEach(item => {
			if (item.startsWith("--")) {
				//	string flag: "--output"
				curFlag = item.replace(/^-+/, "")
				Input.set(curFlag, true)
			} else if (item.startsWith("-")) {
				//	char flags: "-xyz"
				item.replace(/^-+/, "").split("").forEach(flag => {
					curFlag = flag
					Input.set(curFlag, true)
				})
			} else {
				//	some value
				if (!curFlag) {
					//	number instead of flag
					curFlag = curIndex++
				}
				Input.set(curFlag, item)
				curFlag = null
			}
		})
	}
	static get(key = null, dflt = null) {
		if (!Input.flags) {
			Input.setFlags()
		}
		if (!key) {
			return Input.flags
		}
		return Input.flags?.[key] || dflt
	}
	static prompt(text) {
		const rl = readline.createInterface({
			input: process.stdin,
			output: process.stdout,
		})
		return new Promise((resolve, reject) => {
			rl.question(text, value => {
				rl.close()
				resolve(value)
			})
		})
	}
}

module.exports.Input = Input