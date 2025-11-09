const $ = e => document.querySelector(e)
const img = $('#poster')
const gradient = $('.gradient')
const btnPrev = $('#previous')
const btnDownload = $('#download')
const canvas = $('#canvas')
const ctx = canvas.getContext('2d')

img.onload = () => {
    canvas.width = img.width
    canvas.height = img.height
    ctx.drawImage(img, 0, 0, img.width, img.height)
    const imageData = ctx.getImageData(0, 0, img.width, img.height)
    const pixels = imageData.data
    const color = getDominantColor(pixels, img.width, img.height)
    gradient.style.background = `rgba(${color.r}, ${color.g}, ${color.b}, 0.5)`

    btnDownload.addEventListener('click', async () => {
        try {
            const response = await fetch(img.src, {mode: 'cors'})
            const blob = await response.blob()
            const url = URL.createObjectURL(blob)
            const a = document.createElement('a')
            a.href = url
            a.download = 'Next MCU Movie.png'
            a.click()
            URL.revokeObjectURL(url)
        } catch (error) {
            alert('Error downloading the poster.')
        }
    })
}

function getDominantColor(data, width, height) {
    const colorMap = {}
    const step = 25

    for (let y = 0; y < height; y += step) {
        for (let x = 0; x < width; x += step) {
            const index = (y * width + x) * 4
            const r = data[index]
            const g = data[index + 1]
            const b = data[index + 2]
            const key = `${r},${g},${b}`
            colorMap[key] = (colorMap[key] || 0) + 1
        }
    }

    let dominantColor = { r: 0, g: 0, b: 0 }
    let maxCount = 0
    for (let key in colorMap) {
        if (colorMap[key] > maxCount) {
            maxCount = colorMap[key]
            const [r, g, b] = key.split(',').map(Number)
            dominantColor = { r, g, b }
        }
    }

    return dominantColor
}

if (btnPrev) {
    btnPrev.addEventListener('click', () => {
        history.back()
    })
}