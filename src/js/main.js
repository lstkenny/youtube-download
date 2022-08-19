const { Input } = require("./input.js")
const { Output } = require("./output.js")
const fs = require("fs")
const ytdl = require("ytdl-core")

async function main() {
	let url = Input.get("u") || Input.get("url") || await Input.prompt("Youtube URL: ")
	urlInfo = new URL(url)
	const ytDomains = ["youtube.com", "youtu.be"]
	const dm = ytDomains.find(domain => urlInfo.host.includes(domain))
	const id = urlInfo.searchParams.get("v")
	if (!id || !dm) {
		throw new Error("Invalid youtube video URL", 400)
	}
	let videoOutput = Input.get("o") || Input.get("output") || `${id}.mp4`
	const video = ytdl(url)
	let starttime
	video.pipe(fs.createWriteStream(videoOutput))
	video.once("response", () => {
		starttime = Date.now()
	})
	video.on("progress", (chunkLength, downloaded, total) => {
		const percent = downloaded / total
		const downloadedMinutes = (Date.now() - starttime) / 1000 / 60
		const estimatedDownloadTime = (downloadedMinutes / percent) - downloadedMinutes
		readline.cursorTo(process.stdout, 0)
		process.stdout.write(`${(percent * 100).toFixed(2)}% downloaded `)
		process.stdout.write(`(${(downloaded / 1024 / 1024).toFixed(2)}MB of ${(total / 1024 / 1024).toFixed(2)}MB)\n`)
		process.stdout.write(`running for: ${downloadedMinutes.toFixed(2)}minutes`)
		process.stdout.write(`, estimated time left: ${estimatedDownloadTime.toFixed(2)}minutes `)
		readline.moveCursor(process.stdout, 0, -1)
	});
	video.on("end", () => {
		Output.write("\n\n")
	})
}

main().catch(e => {
	Output.error(e.message)
	process.exit(0)
})