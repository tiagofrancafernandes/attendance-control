<form action="#/api/v1/forms/YOUR_FORM_ID/submissions" method="POST" class="w-full  space-y-6">
    <fieldset>
      <label for="name" class="font-semibold pb-2 block">Your Name</label>
      <input type="text" id="name" name="name" placeholder="Enter name" required="" class="bg-gray-100 w-full rounded border px-3 py-1" />
    </fieldset>
    <fieldset>
      <label for="email" class="font-semibold pb-2 block">Your Email</label>
      <input type="email" id="email" name="email" placeholder="Enter email" required="" class="bg-gray-100 w-full rounded border px-3 py-1" />
    </fieldset>
    <fieldset>
      <legend class="font-semibold pb-2 block">How likely are you to recommend us to a friend or colleague?</legend>
      <div class="block pb-2 text-sm font-semibold text-gray-400 md:hidden">
        <span>Very Likely</span>
      </div>
      <div class="flex-wrap space-y-2 md:space-y-0 md:space-x-2 md:flex">
        <label for="0" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>0</span>
            <input type="radio" name="nps" id="0" value="0" />
          </span>
        </label>
        <label for="1" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>1</span>
            <input type="radio" name="nps" id="1" value="1" />
          </span>
        </label>
        <label for="2" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>2</span>
            <input type="radio" name="nps" id="2" value="2" />
          </span>
        </label>
        <label for="3" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>3</span>
            <input type="radio" name="nps" id="3" value="3" />
          </span>
        </label>
        <label for="4" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>4</span>
            <input type="radio" name="nps" id="4" value="4" />
          </span>
        </label>
        <label for="5" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>5</span>
            <input type="radio" name="nps" id="5" value="5" />
          </span>
        </label>
        <label for="6" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>6</span>
            <input type="radio" name="nps" id="6" value="6" />
          </span>
        </label>
        <label for="7" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>7</span>
            <input type="radio" name="nps" id="7" value="7" />
          </span>
        </label>
        <label for="8" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>8</span>
            <input type="radio" name="nps" id="8" value="8" />
          </span>
        </label>
        <label for="9" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>9</span>
            <input type="radio" name="nps" id="9" value="9" />
          </span>
        </label>
        <label for="10" class="relative flex items-center justify-center flex-1 p-2 overflow-hidden font-semibold text-gray-700 transition-all bg-gray-100 border rounded-lg cursor-pointer focus:ring hover:border-gray-200 hover:bg-gray-200">
          <span class="flex flex-col items-center justify-center">
            <span>10</span>
            <input type="radio" name="nps" id="10" value="10" />
          </span>
        </label>
      </div>
      <div class="block pt-2 text-sm font-semibold text-gray-400 md:hidden">
        <span>Very Likely</span>
      </div>
      <div class="items-center justify-between hidden pt-2 text-sm font-semibold text-gray-400 md:flex">
        <span>Not Likely</span>
        <span>Very Likely</span>
      </div>
    </fieldset>
    <fieldset>
      <label for="message" class="font-semibold pb-2 block">Help us by explaining your score</label>
      <textarea id="message" name="message" placeholder="What factors went into your score?" required="" class="bg-gray-100 w-full rounded border px-3 py-1"></textarea>
    </fieldset>
    <button class="bg-cyan-500 rounded-lg text-white px-3 py-2 font-semibold w-full" type="submit">Send Feedback</button>
    <a target="_blank" rel="noopener noreferrer" style="color:rgba(156, 163, 175)" href="https://tailwindcss.com/" class="block w-full pt-2 text-sm text-center">This example uses Tailwind CSS</a>
  </form>
